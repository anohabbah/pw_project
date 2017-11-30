<?php

namespace Tests\Feature;

use App\Media;
use App\Producteur;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class MediaUploadTest extends TestCase
{
    use DatabaseMigrations;

    protected function setUp()
    {
        parent::setUp();

        $this->cleanUploadDirectory();
    }

    /**
     * @inheritdoc
     */
    protected function tearDown()
    {
        parent::tearDown();

        $this->cleanUploadDirectory();
    }

    public function cleanUploadDirectory()
    {
        Storage::disk('public')->deleteDirectory('producteurs');
    }

    protected function uploadFile(array $data = [])
    {
        $file_path = base_path('tests/fixtures/test.jpg');
        $file = new UploadedFile($file_path, 'test.jpg', 'image/*', filesize($file_path), null, true);

        $params = ['avatar' => $file];

        return $this->post(route('media.store'), array_merge($params, $data));
    }

    /** @test */
    public function media_uploading()
    {
        $response = $this->uploadFile()->json();
        $url = $response['url'];
        $filename = basename($url);

        $this->assertDatabaseHas('medias', ['id_media' => $response['id_media'], 'url' => $response['url']]);
        $this->assertEquals('http://localhost:8000/storage/producteurs/' . $filename, $url);
        $this->assertFileExists(base_path('tests/fixtures/storage/producteurs/' . $filename));
    }

    /** @test */
    public function delete_file_when_associated_media_deleted()
    {
        $id_media = $this->uploadFile()->json()['id_media'];
        $media = Media::find($id_media);
        $media->delete();

        $this->assertDatabaseMissing('medias', ['id_media' => $media->id_media]);
        $this->assertFileNotExists(base_path('tests/fixtures/storage/producteurs/' . basename($media->url)));
    }

    /** @test */
    public function delete_media_when_associated_producteur_is_delete()
    {
        $prod = factory(Producteur::class)->create();
        $id_media = $this->uploadFile()->json()['id_media'];
        $media = Media::find($id_media);
        $media->producteur()->associate($prod);
        $media->save();

        $this->assertDatabaseHas('producteurs', ['id_producteur' => $prod->id_producteur]);
        $this->assertDatabaseHas('medias', ['id_media' => $media->id_media, 'id_producteur' => $prod->id_producteur]);

        $prod->fresh();
        $prod->delete();

        $this->assertDatabaseMissing('producteurs', ['id_producteur' => $prod->id_producteur]);
        $this->assertDatabaseMissing('medias', [
            'id_media' => $media->id_media,
            'id_producteur' => $prod->id_producteur
        ]);
    }

    /** @test */
    public function update_producer_profile_picture()
    {
        $prod = factory(Producteur::class)->create();

        $file_path = base_path('tests/fixtures/test.jpg');
        $file = new UploadedFile($file_path, 'test.jpg', 'image/*', filesize($file_path), null, true);

        $params = ['avatar' => $file];
        $response = $this->post(route('media.update', $prod), $params)->json();

        $this->assertEquals($prod->media->url, $response['url']);
    }
}
