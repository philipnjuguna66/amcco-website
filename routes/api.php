  <?php

use App\Events\BlogCreatedEvent;
use Appsorigin\Plots\Models\Blog;
  use Appsorigin\Plots\Models\Project;
  use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('posts', function () {


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
