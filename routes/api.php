  <?php

use App\Events\BlogCreatedEvent;
  use Appsorigin\Blog\Models\Blog;
  use Appsorigin\Plots\Models\Project;
  use Appsorigin\Plots\Models\ProjectLocation;
  use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
  use Illuminate\Support\Facades\Storage;

  Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('projects', function () {




    dispatch(function (){

        $response = Http::get("https://amccopropertiesltd.co.ke/wp-json/wp/v2/properties?_embed&fields=id,title,content&per_page=100");

        if ($response->ok())
        {
            $data  = $response->object();

            foreach ($data as $pro) {

                $url = ((array)$pro->_embedded)['wp:featuredmedia'][0]->source_url;

                $contents = file_get_contents($url);
                $featured_image = substr($url, strrpos($url, '/') + 1);

                $path = "properties". DIRECTORY_SEPARATOR. "featured". DIRECTORY_SEPARATOR . $featured_image;
                Storage::disk('public')->put($path,  $contents, [
                    'visibility' => 'public'
                ]);


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
                    'featured_image' =>$path,
                    'amenities' => $pro->custom_fields->features,
                ];




                foreach ($pro->custom_fields->gallery as $gallery) {

                    $url =  $gallery->url;

                    $contents = file_get_contents($url);
                    $name = substr($url, strrpos($url, '/') + 1);
                    Storage::disk('public')->put("properties". DIRECTORY_SEPARATOR. $name, $contents,[
                        'visibility' => 'public'
                    ]);

                    $projectData['gallery'] =  [
                        "properties". DIRECTORY_SEPARATOR. $name
                    ];
                }

                /** @var Project $project */
                $project = Project::updateOrCreate([
                    'name' => $pro->title->rendered,
                ], $projectData);


                $project->link()->delete();



                $project->link()->create([
                    'slug' => $pro->slug,
                    'type' => 'project',
                ]);

                $project->setCreatedAt(\Carbon\Carbon::parse($pro->modified));

                $project->saveQuietly();


                $project->branches()->delete();

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

        $blogs = Blog::query()->latest('id')->cursor();


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
Route::get('posts', function (Request $request) {

    $page =  $request->page ?? 1;

    dispatch(function () use ($page ){

        $response = Http::get("https://amccopropertiesltd.co.ke/wp-json/wp/v2/posts?_embed&fields=id,title,content&per_page=100&page=$page");

        if ($response->ok())
        {
            $data  = $response->object();

            foreach ($data as $pro) {

                $path = "";

                if (isset(((array)$pro->_embedded)['wp:featuredmedia'][0]))
                {

                    $url = ((array)$pro->_embedded)['wp:featuredmedia'][0]->source_url;

                    $contents = file_get_contents($url);
                    $featured_image = substr($url, strrpos($url, '/') + 1);

                    $path = "blogs". DIRECTORY_SEPARATOR. "featured". DIRECTORY_SEPARATOR . $featured_image;
                    Storage::disk('public')->put($path,  $contents, [
                        'visibility' => 'public'
                    ]);
                }



                $projectData = [
                    'title' => $pro->title->rendered,
                    'is_published' => true,
                    'body' => str($pro->content->rendered)->replace('<div>','')
                        ->replace('</div>', '')->toHtmlString(),
                    'meta_title' => $pro->title->rendered,
                    'meta_description' => str($pro->excerpt->rendered)->limit('156')->value(),
                    'featured_image' =>$path,
                    'type' => \App\Utils\Enums\BlogTypeEnum::POST,
                ];






                /** @var Blog $blog */
                $blog = Blog::updateOrCreate([
                    'title' => $pro->title->rendered,
                ], $projectData);


                $blog->link()->delete();



                $blog->link()->create([
                    'slug' => $pro->slug,
                    'type' => \App\Utils\Enums\PermerlinkTypeEnums::POST,
                ]);

                $blog->setCreatedAt(\Carbon\Carbon::parse($pro->modified));

                $blog->saveQuietly();



                event(new BlogCreatedEvent($blog));

            }



        }
        dump($response->json());

    })->onQueue('properties');




});
Route::get('updates', function () {




      dispatch(function (){

          $response = Http::get("https://amccopropertiesltd.co.ke/wp-json/wp/v2/event-updates?_embed&fields=id,title,content&per_page=100");

          if ($response->ok())
          {
              $data  = $response->object();

              foreach ($data as $pro) {

                  $url = ((array)$pro->_embedded)['wp:featuredmedia'][0]->source_url;

                  $contents = file_get_contents($url);
                  $featured_image = substr($url, strrpos($url, '/') + 1);

                  $path = "blogs". DIRECTORY_SEPARATOR. "featured". DIRECTORY_SEPARATOR . $featured_image;
                  Storage::disk('public')->put($path,  $contents, [
                      'visibility' => 'public'
                  ]);



                  $projectData = [
                      'title' => $pro->title->rendered,
                      'is_published' => true,
                      'body' => str($pro->content->rendered)->replace('<div>','')
                          ->replace('</div>', '')->toHtmlString(),
                      'meta_title' => $pro->title->rendered,
                      'meta_description' => str($pro->content->rendered)->stripTags()->limit('156')->value(),
                      'featured_image' =>$path,
                      'type' => \App\Utils\Enums\BlogTypeEnum::UPDATES,
                  ];






                  /** @var Blog $blog */
                  $blog = Blog::updateOrCreate([
                      'title' => $pro->title->rendered,
                  ], $projectData);


                  $blog->link()->delete();



                  $blog->link()->create([
                      'slug' => $pro->slug,
                      'type' => \App\Utils\Enums\PermerlinkTypeEnums::POST,
                  ]);

                  $blog->setCreatedAt(\Carbon\Carbon::parse($pro->modified));

                  $blog->saveQuietly();



                  event(new BlogCreatedEvent($blog));

              }



          }
          dump($response->json());

      })->onQueue('properties');




      dd('donw');

      $blogs = Blog::query()->latest('id')->cursor();


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
Route::get('media', function (Request $request) {


    $page = $request->page ?? 1;


      dispatch(function () use ( $page){

          $response = Http::get("https://www.optiven.co.ke/wp-json/wp/v2/media/?_embed&per_page=100&page=$page");
          if ($response->ok())
          {
              $data  = $response->object();

              foreach ($data as $pro) {

                  foreach ($pro->media_details->sizes as $index =>  $size)
                  {
                      $url =  $size->source_url;

                      $contents = file_get_contents($url);
                      //  $featured_image = substr($url, strrpos($url, '/') + 1);

                      $path = "wp-content/".str($url)->explode("wp-content")[1];
                      Storage::disk('wp')->put($path,  $contents, [
                          'visibility' => 'public'
                      ]);
                  }
              }
              dd("done");

          }
          dump($response->json());
      })->onQueue('properties');




      dd('donw');

      $blogs = Blog::query()->latest('id')->cursor();


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


Route::get("/test", function (){

    dispatch(function (){
        Blog::all()->each(function (Blog $blog) {
            return event(new BlogCreatedEvent($blog));
        });
        \App\Models\Page::all()->each(function (\App\Models\Page $blog) {
            return event(new \App\Events\PageCreatedEvent($blog));
        });
        Project::all()->each(function (Project $blog) {
            return event(new \App\Events\BlogCreatedEvent($blog));
        });
    });

});
