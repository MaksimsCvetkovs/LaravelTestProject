<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Actions\Fortify\CreateNewUser;

use App\Models\User;
use App\Models\UserGroup;
use App\Models\Model3D;
use App\Models\Project;

use Carbon\Carbon;

use Faker;

class DatabaseSeeder extends Seeder {

    public function run() {
        $faker = Faker\Factory::create();
        $faker->addProvider(new Faker\Provider\lv_LV\Person($faker));

        $userGroup = UserGroup::where("name", "user")->firstOrFail();

        $action = new CreateNewUser;

        $password = $faker->regexify("[A-Z][a-z][0-9][a-z][0-9][a-z][0-9][0-9]");

        for ($i = 0; $i < 100; $i++) {
            $user = $action->create([
                "name" => $faker->name(),
                "email" => $faker->email(),
                "password" => $password,
                "password_confirmation" => $password,
            ]);

            $project = new Project;
            $project->name = $faker->sentence();
            $project->descr = $faker->sentence();
            $project->created_at = Carbon::now();
            $project->created_by = $user->id;
            $project->deleted = false;
            $project->hidden = false;
            $project->save();

            $models = collect();

            for ($j = 0; $j < $faker->randomDigitNotNull(); $j++) {
                $model = new Model3D;
                $model->name = $faker->sentence();
                $model->descr = $faker->sentence();
                $model->created_at = Carbon::now();
                $model->created_by = $user->id;
                $model->deleted = false;
                $model->hidden = false;
                $model->width = $faker->randomFloat(2, 5, 200);
                $model->height = $faker->randomFloat(2, 5, 200);
                $model->length = $faker->randomFloat(2, 5, 200);
                $model->save();

                $models->push($model);
            }

            $project->models()->attach($models->map(fn ($model) => $model->id));
        }
    }
}
