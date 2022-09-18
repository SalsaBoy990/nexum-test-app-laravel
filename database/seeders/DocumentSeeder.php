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
                    'original_filename' => 'kutya.jpg',
                    'view_name' => 'Ez egy kutya.',
                    'file_path' => 'public/uploads/123-kutya.jpg',
                    'version' => '1.0',
                    'user_id' => null,
                    'category_id' => 1
                  
                ]
            ),
            new Document(
                [
                    'original_filename' => 'macska.jpg',
                    'view_name' => 'Ez egy macska.',
                    'file_path' => 'public/uploads/123-macska.jpg',
                    'version' => '1.0',
                    'user_id' => null,
                    'category_id' => 6
                ]
            ),
            new Document(
                [
                    'original_filename' => 'kecske.jpg',
                    'view_name' => 'Ez egy kecske.',
                    'file_path' => 'public/uploads/123-kecske.jpg',
                    'version' => '1.0',
                    'user_id' => null,
                    'category_id' => 16
                ]
            ),
            new Document(
                [
                    'original_filename' => 'teve.jpg',
                    'view_name' => 'Ez egy teve.',
                    'file_path' => 'public/uploads/123-teve.jpg',
                    'version' => '1.0',
                    'user_id' => null,
                    'category_id' => 4
                ]
            ),
        
        ];

        foreach ($documents as $document) {
            $document->save();
        }
    }
}
