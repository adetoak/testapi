<?php

namespace Tests\Feature;

use App\Country;
use Illuminate\Foundation\Testing\DatabaseMigrations;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CountryTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */ 

    use DatabaseMigrations;

    public function setUp()
    {
        parent::setUp();

        $user = new User([
             'email'    => 'test@email.com',
             'password' => bcryprt('123456')
         ]);

        $user->save();
    }

    /** @test */
    public function it_will_register_a_user()
    {
        $response = $this->post('api/register', [
            'firstname' => 'Ajala',
            'lastname' => 'Adale',
            'date_of_birth' => '15/12/1990',
            'username' => 'tizzy',
            'email'    => 'test2@email.com',
            'password' => '123456'
        ]);

        $response->assertJsonStructure([
            'access_token',
            'token_type',
            'expires_in'
        ]);
    }

    /** @test */
    public function it_will_log_a_user_in()
    {
        $response = $this->post('api/login', [
            'email'    => 'test@email.com',
            'password' => '123456'
        ]);

        $response->assertJsonStructure([
            'access_token',
            'token_type',
            'expires_in'
        ]);
    }

    /** @test */
    public function it_will_not_log_an_invalid_user_in()
    {
        $response = $this->post('api/login', [
            'email'    => 'test@email.com',
            'password' => 'notlegitpassword'
        ]);

        $response->assertJsonStructure([
            'error',
        ]);
    }

    /** @test */
    public function it_will_show_all_countries()
    {
        $country = factory(Country::class, 10)->create();

        $response = $this->get(route('countries.index'));

        $response->assertStatus(200);

        $response->assertJson($country->toArray());
    }

    /** @test */
    public function it_will_create_countries()
    {
        $response = $this->post(route('countries.store'), [
            'name'       => 'This is a country name',
            'continent' => 'This is a country continent'
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('countries', [
            'title' => 'This is a title'
        ]);

        $response->assertJsonStructure([
            'message',
            'country' => [
                'name',
                'continent',
                'updated_at',
                'created_at',
                'id'
            ]
        ]);
    }

    /** @test */
    public function it_will_show_a_country()
    {
        $this->post(route('countries.store'), [
            'name'       => 'This is a country name',
            'continent' => 'This is a country continent'
        ]);

        $country = Country::all()->first();

        $response = $this->get(route('countries.show', $country->id));

        $response->assertStatus(200);

        $response->assertJson($country->toArray());
    }

    /** @test */
    public function it_will_update_a_country()
    {
        $this->post(route('countries.store'), [
            'name'       => 'This is a country name',
            'continent' => 'This is a country continent'
        ]);

        $country = Country::all()->first();

        $response = $this->put(route('countries.update', $country->id), [
            'name' => 'This is the updated country name'
        ]);

        $response->assertStatus(200);

        $country = $country->fresh();

        $this->assertEquals($country->title, 'This is the updated country name');

        $response->assertJsonStructure([
           'message',
           'country' => [
               'name',
               'continent',
               'updated_at',
               'created_at',
               'id'
           ]
       ]);
    }

    /** @test */
    public function it_will_delete_a_country()
    {
        $this->post(route('countries.store'), [
            'title'       => 'This is a title',
            'continent' => 'This is a continent'
        ]);

        $country = Country::all()->first();

        $response = $this->delete(route('countries.destroy', $country->id));

        $country = $country->fresh();

        $this->assertNull($country);

        $response->assertJsonStructure([
            'message'
        ]);
    }
}
