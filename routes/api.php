  <?php

use App\Events\BlogCreatedEvent;
use Appsorigin\Plots\Models\Blog;
  use Appsorigin\Plots\Models\Project;
  use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
  use Illuminate\Support\Facades\Storage;

  Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('posts', function () {


        $response = Http::get("https://amccopropertiesltd.co.ke/wp-json/wp/v2/properties?_embed&fields=id,title,content");

        if ($response->ok())
        {
            $data  = $response->object();

            foreach ($data as $pro) {


                dd($pro);

                $projectData = [
                    'use_page_builder' => false,
                    'name' => $pro->title->rendered,
                    'body' => $pro->content->rendered,
                    'status' => $pro->terms->status[0],
                    'price' => $pro->custom_fields->price,
                    //   'meta_title' => $data['meta_title'],
                    //  'meta_description' => $data['meta_description'],
                    //  'location' => $data['location'],
                    //  'purpose' => $data['purpose'],
                    //  'featured_image' => $data['featured_image'],
                    'amenities' => $pro->custom_fields->features,
                ];




                foreach ($pro->custom_fields->gallery as $gallery) {

                    $url =  $gallery->url;

                    $contents = file_get_contents($url);
                    $name = substr($url, strrpos($url, '/') + 1);
                    Storage::put("properties". DIRECTORY_SEPARATOR. $name, $contents);

                    $projectData['gallery'] = "properties". DIRECTORY_SEPARATOR. $name;


                }

            }



        }

        dd($response->json());





        $blogs = \Appsorigin\Blog\Models\Blog::query()->latest('id')->cursor();


        $yourApiKey = env('OPEN_AI_API_KEY');


        foreach ($blogs as $blog) {
            $client = OpenAI::client($yourApiKey);

            $result = $client->completions()->create([
                'model' => 'text-davinci-003',
                'prompt' => 'correct errors and typos '. $blog->body,
            ]);

            $blog->body = $result['choices'][0]['text'];


            $blog->save();


        }



});
