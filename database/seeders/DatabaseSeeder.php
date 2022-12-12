<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Actions\Fortify\CreateNewUser;

use App\Models\Manf;
use App\Models\ManfRole;
use App\Models\User;
use App\Models\UserGroup;
use App\Models\Model3D;
use App\Models\Project;
use App\Models\Service;

use Carbon\Carbon;

use Faker;

class DatabaseSeeder extends Seeder {

    public function run() {
        $user = (new CreateNewUser)->create([
            "name" => "MAX",
            "email" => "maksimouscvetkous@gmail.com",
            "password" => "ShwWD9ctephY7*q",
            "password_confirmation" => "ShwWD9ctephY7*q",
        ]);

        $faker = Faker\Factory::create();
        $faker->addProvider(new Faker\Provider\lv_LV\Person($faker));

        for ($i = 0; $i < 12; $i++) {
            $project = $this->fakeProject($faker, $user, modelsCount: 4, hiddenProject: true, hiddenModels: true);
        }

        $userGroup = UserGroup::where("name", "user")->firstOrFail();

        $action = new CreateNewUser;

        for ($i = 0; $i < 100; $i++) {
            $user = $this->fakeUser($faker, $action);
            $this->fakeProject($faker, $user, modelsCount: $faker->randomDigitNotNull());

            if ($faker->boolean()) {
                $this->fakeManf($faker, $user, servicesCount: $faker->randomDigitNotNull());
            }
        }
    }

    protected function fakeUser($faker, $action) {
        $password = $faker->regexify("[A-Z][a-z][0-9][a-z][0-9][a-z][0-9][0-9]");

        return $action->create([
            "name" => $faker->name(),
            "email" => $faker->email(),
            "password" => $password,
            "password_confirmation" => $password,
        ]);
    }

    protected function fakeProject($faker, $user, $modelsCount, $hiddenProject = false, $hiddenModels = false) {
        $project = new Project;
        $project->name = "PROJECT " . $faker->sentence();
        $project->descr = $faker->sentence();
        $project->created_at = Carbon::now();
        $project->created_by = $user->id;
        $project->deleted = false;
        $project->hidden = $hiddenProject;
        $project->save();

        $models = collect();

        for ($j = 0; $j < $modelsCount; $j++) {
            $models->push($this->fakeModel($faker, $user, $hiddenModels));
        }

        $project->models()->attach($models->map(fn ($model) => $model->id));

        return $project;
    }

    protected function fakeModel($faker, $user, $hidden = false) {
        $model = new Model3D;
        $model->name = "MODEL " . $faker->sentence();
        $model->descr = $faker->sentence();
        $model->created_at = Carbon::now();
        $model->created_by = $user->id;
        $model->deleted = false;
        $model->hidden = $hidden;
        $model->width = $faker->randomFloat(2, 5, 200);
        $model->height = $faker->randomFloat(2, 5, 200);
        $model->length = $faker->randomFloat(2, 5, 200);
        $model->save();

        return $model;
    }

    protected function fakeManf($faker, $user, $servicesCount) {
        $manf = new Manf;
        $manf->name = "MANF " . $faker->sentence();
        $manf->descr = $faker->sentence();
        $manf->email = $faker->email();
        $manf->deleted = false;
        $manf->hidden = false;
        $manf->save();

        $manfRole = new ManfRole;
        $manfRole->manf_id = $manf->id;
        $manfRole->name = "Creator";
        $manfRole->can_edit = true;
        $manfRole->deleted = false;
        $manfRole->save();

        $manfRole->users()->attach($user->id);

        for ($i = 0; $i < $servicesCount; $i++) {
            $service = new Service;
            $service->manf_id = $manf->id;
            $service->name = "SERVICE " . $faker->sentence();
            $service->descr = $faker->sentence();
            $service->created_by = $user->id;
            $service->deleted = false;
            $service->hidden = false;
            $service->save();

            if ($faker->boolean()) {
                $service->printers()->attach([1, 2]);
            } else {
                $service->printers()->attach($faker->boolean() ? 1 : 2);
            }
        }
    }
}
