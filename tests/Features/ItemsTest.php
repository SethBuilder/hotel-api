<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
use App\Item;
class FeatureTest extends TestCase
{

    use DatabaseTransactions;

    /**
     * @return void
     * @test
     */
    public function a_user_can_create_location()
    {
        // Given I am a user who's logged in
        $this->actingAs(factory('App\User', 'hotelier')->create());

        // When I hit /locations endpoint to create new location while passing necessary data
        $this
            ->post('/api/locations',
            [
                'city' => 'New York', 
                'state' => 'New York', 
                'country' => 'United States', 
                'zip_code' =>  '10007'
            ])
            // Then app must return city name as json
            ->seeJson([
                'city' => 'New York'
            ]);
            

        // Also location must be in database
        $this->seeInDatabase('locations', ['city' => 'New York']);
    }



    /**
     * @return void
     * @test
     */
    public function a_hotelier_can_create_item()
    {
        

        // Given I am a user who's logged in and there's a location in database
        $this->actingAs(factory('App\User', 'hotelier')->create());
        $location = factory('App\Location')->create();

        // When I hit /items endpoint to create new item while passing necessary data
        $this
            ->post('/api/items',
            [
                'name' => 'The Plaza Hotel', 
                'rating' => 5, 
                'category' => 'hotel', 
                'location_id' =>  $location->id,
                'image' => 'http://plaza.hotel',
                'reputation' => 1000,
                'availability' => 500,
                'price' => 5000
            ])
            // Then app must return item name as json
            ->seeJson([
                'name' => 'The Plaza Hotel'
            ]);

        // Also item must be in database
        $this->seeInDatabase('items', ['name' => 'The Plaza Hotel']);
    }


    /**
     * @return void
     * @test
     */
    public function a_hotelier_can_update_her_item()
    {
        // Given I am a user who's logged in and there's a location and item in database
        $user = factory('App\User', 'hotelier')->create();
        $this->actingAs($user);
        $location = factory('App\Location')->create();
        $item = Item::create([
            'name' => 'The Plaza Hotel', 
            'rating' => 5, 
            'category' => 'hotel', 
            'location_id' =>  $location->id,
            'image' => 'http://plaza.hotel',
            'reputation' => 1000,
            'availability' => 500,
            'hotelier_id' => $user->userable_id,
            'price' => 5000
        ]);

        // When I hit /items endpoint to create new item while passing necessary data
        $this
            ->patch("/api/items/$item->id", [
                'name' => 'The Ritz-Carlton New York, Central Park'
            ])
            // Then app must return item name as json
            ->seeJson([
                'name' => 'The Ritz-Carlton New York, Central Park'
            ]);

        // Also item must be in database
        $this->seeInDatabase('items', ['name' => 'The Ritz-Carlton New York, Central Park']);
    }

    /**
     * @return void
     * @test
     */
    public function a_hotelier_can_not_update_item_she_does_not_own()
    {
        // Given I am a user who's logged in and there's a location and item in database
        $user = factory('App\User', 'hotelier')->create();
        $otherUser = factory('App\User', 'hotelier')->create();
        $this->actingAs($user);
        $location = factory('App\Location')->create();
        $item = Item::create([
            'name' => 'The Plaza Hotel', 
            'rating' => 5, 
            'category' => 'hotel', 
            'location_id' =>  $location->id,
            'image' => 'http://plaza.hotel',
            'reputation' => 1000,
            'availability' => 500,
            'hotelier_id' => $otherUser->userable_id,
            'price' => 5000
        ]);

        // When I hit /items endpoint to create new item while passing necessary data
        $this
            ->patch("/api/items/$item->id", [
                'name' => 'The Ritz-Carlton New York, Central Park'
            ])
            // Then app must return item name as json
            ->seeJson([
                "title" => "You are not authorized"
            ]);
    }
    /**
     * @return void
     * @test
     */
    public function a_hotelier_can_delete_her_item()
    {
        // Given I am a user who's logged in and there's a location and item in database
        $user = factory('App\User', 'hotelier')->create();
        $this->actingAs($user);
        $location = factory('App\Location')->create();
        $item = Item::create([
            'name' => 'The Plaza Hotel', 
            'rating' => 5, 
            'category' => 'hotel', 
            'location_id' =>  $location->id,
            'image' => 'http://plaza.hotel',
            'reputation' => 1000,
            'availability' => 500,
            'hotelier_id' => $user->userable_id,
            'price' => 5000
        ]);

        // When I hit /items endpoint to create new item while passing necessary data
        $this
            ->delete("/api/items/$item->id")
            // Then app must return item name as json
            // dd($this->response->getContent());
            ->assertEquals("deleted successfully", $this->response->getContent());

        // Also item must be in database
        $this->notSeeInDatabase('items', ['name' => 'The Ritz-Carlton New York, Central Park']);
    }

    /**
     * @return void
     * @test
     */
    public function a_hotelier_can_view_her_item()
    {
        // Given I am a user who's logged in and there's a location and item in database
        $user = factory('App\User', 'hotelier')->create();
        $this->actingAs($user);
        $location = factory('App\Location')->create();
        $item = Item::create([
            'name' => 'The Plaza Hotel', 
            'rating' => 5, 
            'category' => 'hotel', 
            'location_id' =>  $location->id,
            'image' => 'http://plaza.hotel',
            'reputation' => 1000,
            'availability' => 500,
            'hotelier_id' => $user->userable_id,
            'price' => 5000
        ]);

        // When I hit /items endpoint to create new item while passing necessary data
        $this
            ->get("/api/items/$item->id", [
                'name' => 'The Plaza Hotel'
            ])
            // Then app must return item name as json
            ->seeJson([
                'name' => 'The Plaza Hotel'
            ]);

        // Also item must be in database
        $this->seeInDatabase('items', ['name' => 'The Plaza Hotel']);
    }
}
