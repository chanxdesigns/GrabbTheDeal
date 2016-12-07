<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

//Demo User Details Generator
$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'username' => $faker->userName,
        'email' => $faker->safeEmail,
        'password' => bcrypt(str_random(10)),
        'email_token' => str_random(10),
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'country' => $faker->country,
        'phone_number' => $faker->phoneNumber
    ];
});

//Demo Store Details generator
$factory->define(App\Store::class, function (Faker\Generator $faker){
    return [
        'store_name' => 'Jabong',
        'store_about' => $faker->text(300),
        'store_url' => 'http://'.$faker->domainName,
        'store_img' => '/assets/img/brands/Amazon-Logo.jpg',
        'store_category' => 'Fashion',
        'store_id' => $faker->randomDigit,
        'store_slug' => 'test-store'
    ];
});

//Offers Demo Generator
$factory->define(App\Offer::class, function (Faker\Generator $faker) {
    return [
        'offer_name' => $faker->catchPhrase,
        'offer_slug' => 'make-something-sluggy',
        'offer_id' => $faker->randomDigit,
        'offer_category' => 'Fashion',
        'offer_store' => 'Jabong',
        'offer_verified' => 'Y',
        'offer_featured' => 'Y',
        'offer_link' => $faker->url,
        'offer_validity' => $faker->date('Y-m-d')
    ];
});