<?php

namespace Database\Seeders;

use App\Models\BoardingHouse;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BoardingHouseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $bh = [
            [
                'name' => "Stern's Boarding House",
                'landlord_id' => "1",
                'user_id' => "1",
                'address' => 'Pob. Centro, Clarin, Bohol',
                'rating' => '2',
                'latitude' => '9.961151266957987',
                'longitude' => '124.02385739523382',
                'description' => 'I didnt choose the old popular ones like nano machine and many more since theyre well known peaks.',
                'image' => 'https://i.pinimg.com/236x/ad/c8/ae/adc8aecb926cb6e57ef2b849f1ddaeea.jpg',
                'gender_preference' => 'male_and_female',
            ],
            // [
            //     'name' => "Tito's Boarding House",
            //     'user_id' => "2",
            //     'address' => "Tubigon, Bohol",
            //     'latitude' => '9.961151266957987',
            //     'longitude' => '124.02385739523382',
            //     'description' => 'I didnt choose the old popular ones like nano machine and many more since theyre well known peaks.',
            //     'image' => 'https://i.pinimg.com/236x/a6/c6/2d/a6c62d24a8918dcd1d5899e21a346a84.jpg',
            // ],
            // [
            //     'name' => "Vincy's Boarding House",
            //     'user_id' => "3",
            //     'address' => "Tubigon, Bohol",
            //     'latitude' => '9.961151266957987',
            //     'longitude' => '124.02385739523382',
            //     'description' => 'I didnt choose the old popular ones like nano machine and many more since theyre well known peaks.',
            //     'image' => 'https://i.pinimg.com/236x/6f/66/f7/6f66f782f4b4fb3fab18ce2f6d3e3857.jpg',
            // ],

            // [
            //     'name' => "Vincy's Boarding House",
            //     'user_id' => "4",
            //     'address' => "Tubigon, Bohol",
            //     'latitude' => '9.961151266957987',
            //     'longitude' => '124.02385739523382',
            //     'description' => 'I didnt choose the old popular ones like nano machine and many more since theyre well known peaks.',
            //     'image' => 'https://i.pinimg.com/236x/6f/66/f7/6f66f782f4b4fb3fab18ce2f6d3e3857.jpg',
            // ],

            // [
            //     'name' => "Vincy's Boarding House",
            //     'user_id' => "5",
            //     'address' => "Tubigon, Bohol",
            //     'latitude' => '9.961151266957987',
            //     'longitude' => '124.02385739523382',
            //     'description' => 'I didnt choose the old popular ones like nano machine and many more since theyre well known peaks.',
            //     'image' => 'https://i.pinimg.com/236x/6f/66/f7/6f66f782f4b4fb3fab18ce2f6d3e3857.jpg',
            // ],

            // [
            //     'name' => "Vincy's Boarding House",
            //     'user_id' => "6",
            //     'address' => "Tubigon, Bohol",
            //     'latitude' => '9.961151266957987',
            //     'longitude' => '124.02385739523382',
            //     'description' => 'I didnt choose the old popular ones like nano machine and many more since theyre well known peaks.',
            //     'image' => 'https://i.pinimg.com/236x/6f/66/f7/6f66f782f4b4fb3fab18ce2f6d3e3857.jpg',
            // ],
            // [
            //     'name' => "Vincy's Boarding House",
            //     'user_id' => "7",
            //     'address' => "Tubigon, Bohol",
            //     'latitude' => '9.961151266957987',
            //     'longitude' => '124.02385739523382',
            //     'description' => 'I didnt choose the old popular ones like nano machine and many more since theyre well known peaks.',
            //     'image' => 'https://i.pinimg.com/236x/6f/66/f7/6f66f782f4b4fb3fab18ce2f6d3e3857.jpg',
            // ],
            // [
            //     'name' => "Vincy's Boarding House",
            //     'user_id' => "8",
            //     'address' => "Tubigon, Bohol",
            //     'latitude' => '9.961151266957987',
            //     'longitude' => '124.02385739523382',
            //     'description' => 'I didnt choose the old popular ones like nano machine and many more since theyre well known peaks.',
            //     'image' => 'https://i.pinimg.com/236x/6f/66/f7/6f66f782f4b4fb3fab18ce2f6d3e3857.jpg',
            // ],
            // [
            //     'name' => "Vincy's Boarding House",
            //     'user_id' => "9",
            //     'address' => "Tubigon, Bohol",
            //     'latitude' => '9.961151266957987',
            //     'longitude' => '124.02385739523382',
            //     'description' => 'I didnt choose the old popular ones like nano machine and many more since theyre well known peaks.',
            //     'image' => 'https://i.pinimg.com/236x/6f/66/f7/6f66f782f4b4fb3fab18ce2f6d3e3857.jpg',
            // ],
            
        ];

        foreach($bh as $bh) {
            BoardingHouse::create($bh);
        }
    }
}
