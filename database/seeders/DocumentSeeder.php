<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Document;

class DocumentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $documents = [
            new Document(
                [
                    'original_filename' => 'dummy.pdf',
                    'view_name' => 'Tesztdokumentum.',
                    'file_path' => 'public/uploads/123-dummy.pdf',
                    'version' => '1.0',
                    'user_id' => 1,
                    'category_id' => 1
                  
                ]
            ),
            new Document(
                [
                    'original_filename' => 'sample-pdf-file.pdf',
                    'view_name' => 'Még egy teszt.',
                    'file_path' => 'public/uploads/123-sample-pdf-file.pdf',
                    'version' => '1.0',
                    'user_id' => 1,
                    'category_id' => 1
                ]
            ),
            new Document(
                [
                    'original_filename' => 'kecske.jpg',
                    'view_name' => 'Ez egy kecske.',
                    'file_path' => 'public/uploads/123-kecske.jpg',
                    'version' => '1.0',
                    'user_id' => 1,
                    'category_id' => 1
                ]
            ),
            new Document(
                [
                    'original_filename' => 'teve.jpg',
                    'view_name' => 'Ez egy teve.',
                    'file_path' => 'public/uploads/123-teve.jpg',
                    'version' => '1.0',
                    'user_id' => 1,
                    'category_id' => 2
                ]
            ),
        
        ];

        foreach ($documents as $document) {
            $document->save();
        }
    }
}
