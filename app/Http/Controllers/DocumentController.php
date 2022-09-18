<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDocumentRequest;
use App\Http\Requests\UpdateDocumentRequest;
use App\Models\Document;
use App\Support\InteractsWithBanner;

class DocumentController extends Controller
{
    use InteractsWithBanner;

    protected $pathNormalizer;

    // dependency injection is needed because cannot call static methods (defined in WhitespacePathNormalizer), 
    public function __construct(\League\Flysystem\WhitespacePathNormalizer $pathNormalizer)
    {
        $this->pathNormalizer = $pathNormalizer;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreDocumentRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDocumentRequest $request)
    {
        $data = [
            'user_id' => auth()->user()->id,
            'view_name' => $request->view_name,
            'category_id' => $request->category_id,
            'version' => '1.0',
        ];

        $file = $request->file('file_path');

        // check if new image needs to be uploaded
        if ($file !== null && $file->isValid()) {
            $data['original_filename'] = $file->getClientOriginalName();
            $fileName = time() . '-' . $data['original_filename'];

            $filePath = $file->storeAs('public/uploads', $this->pathNormalizer->normalizePath($fileName));
            if (!$filePath) {
                $this->banner('Hiba a dokumentum feltöltés során.', 'error');
                return back();
            }
            $data['file_path'] = $filePath;
        } else {
            $this->banner('Hiba a dokumentum feltöltés során.', 'error');
            return back();
        }

        Document::create($data);

        $this->banner(__('Dokumentum sikeresen feltöltve'));

        return back();
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateDocumentRequest  $request
     * @param  \App\Models\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDocumentRequest $request, Document $document)
    {
        $data = [
            'user_id' => auth()->user()->id,
            'view_name' => $request->view_name,
            'category_id' => $request->category_id,
            'version' => '1.0',
        ];

        $file = $request->file('file_path');

        // check if new image needs to be uploaded
        if ($file !== null) {

            if ($file->isValid()) {
                $data['original_filename'] = $file->getClientOriginalName();
                $fileName = time() . '-' . $data['original_filename'];

                $filePath = $file->storeAs('public/uploads', $this->pathNormalizer->normalizePath($fileName));
                if (!$filePath) {
                    $this->banner('Hiba a dokumentum feltöltés során.', 'error');
                    return back();
                }
                $data['file_path'] = $filePath;
            } else {
                $this->banner('Hiba a dokumentum feltöltés során.', 'error');
                return back();
            }
        }

        $document->update($data);

        $this->banner(__('Dokumentum sikeresen módosítva!'));

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function destroy(Document $document)
    {
        $oldName = htmlentities($document->viewname);
        $document->deleteOrFail();

        session()->forget('documents');

        $this->banner('"' . $oldName . '"' . ' sikeresen törölve!');
        return redirect()->route('dashboard');
    }
}
