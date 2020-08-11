<?php
/**
 * Invoice Ninja (https://invoiceninja.com)
 *
 * @link https://github.com/invoiceninja/invoiceninja source repository
 *
 * @copyright Copyright (c) 2020. Invoice Ninja LLC (https://invoiceninja.com)
 *
 * @license https://opensource.org/licenses/AAL
 */

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\BaseController;
use App\Models\Company;
use App\Models\CompanyToken;
use App\Models\Product;
use App\Transformers\ProductTransformer;
use App\Utils\Traits\MakesHash;
use Illuminate\Http\Request;

class ProductController extends BaseController
{
    use MakesHash;
    
    protected $entity_type = Product::class;

    protected $entity_transformer = ProductTransformer::class;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $company = Company::where('company_key', $request->header('X-API-COMPANY-KEY'))->first();

        if(!$company->enable_shop_api)
            return response()->json(['message' => 'Shop is disabled', 'errors' => new \stdClass],403);

        $products = Product::where('company_id', $company->id);

        return $this->listResponse($products);
    }

    public function show(Request $request, string $product_key)
    {
        $company = Company::where('company_key', $request->header('X-API-COMPANY-KEY'))->first();

        if(!$company->enable_shop_api)
            return response()->json(['message' => 'Shop is disabled', 'errors' => new \stdClass],403);
        
        $product = Product::where('company_id', $company->id)
                            ->where('product_key', $product_key)
                            ->first();

        return $this->itemResponse($product);
    }
}
