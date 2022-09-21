<?php
namespace App\Traits;

use App\Models\Contact;
use App\Models\ProfitWorks;
use App\Models\SEO;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

trait StaticActionTrait
{
    /**
     * Handle static routes
     *
     * @param string $methodName
     * @param mixed $parameters
     * @throws NotFoundHttpException
     * @return mixed
     */
    public function handle(string $methodName, mixed $parameters): mixed
    {
        $data = [];
//        $jsonData = file_get_contents(realpath('../resources/static_content.json'));
//        $jsonData = json_decode($jsonData);

        // transform to camelCase if $methodName (route) contains '-' sign
        if (strpos($methodName, '-') !== false) {
            $methodName = explode('-', $methodName);
            $newMethodName = $methodName[0];
            for ($i = 1; $i < count($methodName); $i++) {
                $newMethodName .= ucfirst($methodName[$i]);
            }
            $methodName = $newMethodName;
        }

//        $jsonData = $jsonData ?-> content ?-> $methodName;
//        if (!empty($jsonData)) {
//            foreach ($jsonData as $key => $item) {
//                $data[$key] = $item;
//            }
//        }
        if (!empty($parameters)) {
            if (is_array($parameters)) {
                foreach ($parameters as $key => $value) {
                    $data[$key] = $value;
                }
            }
        }
        $data['seo'] = SEO::where('page', $methodName)->first();

        if ($methodName == 'contacts') {
            $data['contacts'] = Contact::all();
        }
        if ($methodName == 'about') {
            $data['works'] = ProfitWorks::all();
        }
        $viewName = 'static.' . $methodName . '.index';
        if (view()->exists($viewName)) {
            return view($viewName, $data);
        }

        throw new NotFoundHttpException();
    }
}
