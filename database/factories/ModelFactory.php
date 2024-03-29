<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\User;
use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(User::class, function (Faker $faker) {
    return [
        'github_url'           => $faker->url,
        'city'                 => $faker->city,
        'name'                 => $faker->userName,
        'github_name'          => $faker->userName,
        'twitter_account'      => $faker->userName,
        'company'              => $faker->userName,
        'personal_website'     => $faker->url,
        'image_url'            => $faker->url,
        'introduction'         => $faker->sentence,
        'certification'        => $faker->sentence,
        'email'                => $faker->email,
        'password'             => 'xxx',
        'verified'             => true,
        'login_token'          => 'uDFDJys7iwM0fTXuLNNH',
        'created_at'           => Carbon::now()->toDateTimeString(),
        'updated_at'           => Carbon::now()->toDateTimeString(),
    ];
});
$factory->define(Topic::class, function (Faker $faker) {
    return [
        'title'      => $faker->sentence(),
        'body'       => $faker->text(),
        'created_at' => Carbon::now()->toDateTimeString(),
        'updated_at' => Carbon::now()->toDateTimeString(),
    ];
});
$factory->define(Reply::class, function (Faker $faker) {
    $body = $faker->text();
    return [
        'body'          => $body,
        'body_original' => $body,
        'created_at'    => Carbon::now()->toDateTimeString(),
        'updated_at'    => Carbon::now()->toDateTimeString(),
    ];
});
$factory->define(Site::class, function (Faker $faker) {
    return [
        'title'         => $faker->userName,
        'description'   => $faker->sentence,
        'type'          => $faker->randomElement(['site', 'blog', 'weibo', 'dev_service']),
        'favicon'       => '/assets/images/favicon.png',
        'link'          => $faker->url,
        'created_at'    => Carbon::now()->toDateTimeString(),
        'updated_at'    => Carbon::now()->toDateTimeString(),
    ];
});