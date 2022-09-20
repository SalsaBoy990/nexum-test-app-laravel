<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDocumentRequest;
use App\Http\Requests\UpdateDocumentRequest;
use App\Models\Document;
use App\Models\Category;
use App\Support\InteractsWithBanner;
use Illuminate\Support\Facades\Gate;

class DocumentController extends Controller
{
    use InteractsWithBanner;

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreDocumentRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDocumentRequest $request, Category $category)
    {
        if (Gate::denies('authorize_upload_to_category', $category)) {
            $this->banner('Nincs feltöltési jogod a kategóriához.', 'danger');
            return redirect()->route('dashboard');
        }

        $data = [
            'user_id' => auth()->user()->id,
            'view_name' => $request->view_name,
            'category_id' => $request->category_id,
            'version' => '1.0',
        ];

        $file = $request->file('file_path');

        $success = Document::uploadFile($file, $data);
        if (!$success) {
            $this->banner('Hiba a dokumentum-feltöltés során.', 'danger');
            return redirect()->route('dashboard');
        }

        Document::create($data);
        $this->banner(__('Dokumentum sikeresen feltöltve'));
        return redirect()->route('dashboard');
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
        $userId = intval(auth()->user()->id);
        $categoryId = intval($request->category_id);
        $category = Category::findOrFail($categoryId);

        if (Gate::denies('authorize_upload_to_category', $category)) {
            $this->banner('Nincs feltöltési jogod a kategóriához.', 'danger');
            return redirect()->route('dashboard');
        }

        $data = [
            'user_id' => $userId,
            'view_name' => $request->view_name,
            'category_id' => $categoryId,
            'version' => '1.0',
        ];

        $file = $request->file('file_path');

        // check if new image needs to be uploaded
        if ($file) {
            $success = Document::uploadFile($file, $data);
            if (!$success) {
                $this->banner('Hiba a dokumentum-feltöltés során.', 'danger');
                return redirect()->route('dashboard');
            }
        }

        $document->update($data);

        $this->banner(__('Dokumentum sikeresen módosítva!'));

        return redirect()->route('dashboard');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function destroy(Document $document)
    {
        $oldName = htmlentities($document->view_name);
        $document->deleteOrFail();

        $this->banner('"' . $oldName . '"' . ' sikeresen törölve!');
        return redirect()->route('dashboard');
    }
}
