<?

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Social;

class ClientSocialController extends Controller
{
    public function index()
    {
        $socials = Social::where('status', 1)->get(); 
        return view('client.component.footer', compact('socials'));
    }
}
