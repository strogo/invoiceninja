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
use App\Transformers\Shop\CompanyShopProfileTransformer;
use App\Utils\Traits\MakesHash;
use Illuminate\Http\Request;

class ProfileController extends BaseController
{
    use MakesHash;
    
    protected $entity_type = Company::class;

    protected $entity_transformer = CompanyShopProfileTransformer::class;


    public function show(Request $request)
    {
        $company = Company::where('company_key', $request->header('X-API-COMPANY-KEY'))->first();

        if(!$company->enable_shop_api)
            return response()->json(['message' => 'Shop is disabled', 'errors' => new \stdClass],403);

        return $this->itemResponse($company);
    }
}
