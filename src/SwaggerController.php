<?php 

namespace Sargilla\Swagger\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\File;
use Illuminate\Routing\Controller;

class SwaggerController extends Controller
{
    public function definitions($page = 'api-docs.json')
    {
        if (config('swagger.auto-generate')) {
            $this->regenerateDefinitions();
        }

        $filePath = config('swagger.doc-dir') . "/{$page}";

        if (File::extension($filePath) === "") {
            $filePath .= '.json';
        }

        if (!File::exists($filePath)) {
            app()->abort(404, "Cannot find {$filePath}");
        }

        $content = File::get($filePath);

        return response($content, 200, array(
            'Content-Type' => 'application/json'
        ));
    }

    public function ui(Request $request)
    {
        if (config('swagger.auto-generate')) {
            $this->regenerateDefinitions();
        }

        if (config('swagger.behind-reverse-proxy')) {
            $proxy = $request->server('REMOTE_ADDR');
            $request->setTrustedProxies(array($proxy));
        }

        //need the / at the end to avoid CORS errors on Homestead systems.
        $response = response()->view('swagger::index', [
                'urlToDocs' => url(config('swagger.doc-route')),
                'requestHeaders' => config('swagger.requestHeaders'),
                'clientId' => $request->input('client_id'),
                'clientSecret' => $request->input('client_secret'),
                'realm' => $request->input('realm'),
                'appName' => $request->input('appName'),
                'apiKey' => config('swagger.api-key'),
            ]
        );

        foreach (config('swagger.viewHeaders', []) as $key => $value) {
            $response->header($key, $value);
        }

        return $response;
    }

    private function regenerateDefinitions()
    {
        $dir = config('swagger.app-dir');

        if (is_array($dir)) {
            $appDir = [];
            foreach($dir as $d) {
                $appDir[] = base_path($d);
            }
        } else {
            $appDir = base_path($dir);
        }

        $docDir = config('swagger.doc-dir');

        if (!File::exists($docDir)) {
            File::makeDirectory($docDir);
        }

        if (is_writable($docDir)) {
            $excludeDirs = config('swagger.excludes');

            $swagger = \Swagger\scan($appDir, [
                'exclude' => $excludeDirs
            ]);

            $swagger->definitions = 
            [
                'Club'=>
                    [
                        'type'=>'object', 
                        'properties' => 
                            [
                                'nombre' =>
                                [
                                    'type' => 'string',
                                ],
                                'historia' =>
                                [
                                    'type' => 'string',
                                ]
                            ]
                    ]
            ];
            //dd($swagger);
            $filename = $docDir . '/api-docs.json';
            file_put_contents($filename, $swagger);
        }
    }
}
