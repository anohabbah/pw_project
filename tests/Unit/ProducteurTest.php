<?php

namespace Tests\Unit;

use App\Media;
use App\Producteur;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ProducteurTest extends TestCase
{
    use DatabaseMigrations;

   /** @test */
   public function a_producer_has_a_profile_avatar()
   {
       $prod = factory(Producteur::class)->create();
       $media = factory(Media::class)->create();
       $media->producteur()->associate($prod);
       $media->save();

       $this->assertInstanceOf(Media::class, $prod->fresh()->media);
   }
}
