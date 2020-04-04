<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\City;

class CitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cities = ['София', 'Пловдив', 'Кюстендил', 'Варна', 'Бургас',
            'Русе', 'Стара Загора', 'Малко Търново', 'Видин', 'Карлово', 'Чирпан', 'Чепеларе',
            'Смолян', 'Сандански', 'Петрич', 'Благоевград', 'Разлог', 'Горна Оряховица',
            'Габрово', 'Велико Търново', 'Добрич', 'Попово', 'Монтана', 'Перник', 'Радомир',
            'Белово', 'Костенец', 'Първомай'
            ];

        DB::table('cities')->truncate();

        for ($i = 0; $i < count($cities); $i++) {
            City::create([
                'name' => $cities[$i],
                'slug' => Str::slug($cities[$i])
            ]);
        }
    }
}
