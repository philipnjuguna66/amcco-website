  <?php

use App\Events\BlogCreatedEvent;
use Appsorigin\Plots\Models\Blog;
  use Appsorigin\Plots\Models\Project;
  use Appsorigin\Plots\Models\ProjectLocation;
  use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
  use Illuminate\Support\Facades\Storage;

  Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('posts', function () {




    dispatch(function (){

        $response = Http::get("https://amccopropertiesltd.co.ke/wp-json/wp/v2/properties?_embed&fields=id,title,content&per_page=100");

        if ($response->ok())
        {
            $data  = $response->object();

            foreach ($data as $pro) {

                $url = ((array)$pro->_embedded)['wp:featuredmedia'][0]->source_url;

                $contents = file_get_contents($url);
                $name = substr($url, strrpos($url, '/') + 1);
                Storage::put("properties". DIRECTORY_SEPARATOR. $name, $contents);


                foreach ($pro->terms->location as $location) {

                    \Appsorigin\Plots\Models\Location::updateOrCreate([
                        'name' => $location
                    ],[
                        'slug' => str($location)->lower()->slug()->value()
                    ]);

                }


                $projectData = [
                    'use_page_builder' => false,
                    'name' => $pro->title->rendered,
                    'body' => $pro->content->rendered,
                    'status' => $pro->terms->status[0],
                    'price' => $pro->custom_fields->price,
                    'meta_title' => $pro->title->rendered,
                    'meta_description' => str($pro->content->rendered)->limit('156')->value(),
                     'location' => $pro->terms->location[0] ?? "Kikuyu",
                     'purpose' => "residential",
                    'featured_image' => "properties". DIRECTORY_SEPARATOR. $name,
                    'amenities' => $pro->custom_fields->features,
                ];




                foreach ($pro->custom_fields->gallery as $gallery) {

                    $url =  $gallery->url;

                    $contents = file_get_contents($url);
                    $name = substr($url, strrpos($url, '/') + 1);
                    Storage::put("properties". DIRECTORY_SEPARATOR. $name, $contents);

                    $projectData['gallery'] = "properties". DIRECTORY_SEPARATOR. $name;


                }
                dd($projectData);

                /** @var Project $project */
                $project = Project::create($projectData);



                $project->link()->create([
                    'slug' => $pro->slug,
                    'type' => 'project',
                ]);

                $project->setCreatedAt(\Carbon\Carbon::parse($pro->modified));

                $project->saveQuietly();

                foreach (\Appsorigin\Plots\Models\Location::query()->whereIn('name', $pro->terms->location)->pluck('id') as $locationId) {

                    ProjectLocation::create([
                        'location_id' => $locationId,
                        'project_id' => $project->id
                    ]);
                }

                event(new BlogCreatedEvent($project));

            }



        }
        dump($response->json());

    })->onQueue('properties');




dd('donw');

        $blogs = \Appsorigin\Blog\Models\Blog::query()->latest('id')->cursor();


        $yourApiKey = env('OPEN_AI_API_KEY');


        foreach ($blogs as $blog) {
            $client = OpenAI::client($yourApiKey);

            $result = $client->completions()->create([
                'model' => 'text-davinci-003',
                'prompt' => 'correct errors and typos and the gramma without changing the wording'. $blog->body,
            ]);

            $blog->body = $result['choices'][0]['text'];


            $blog->save();


        }



});
