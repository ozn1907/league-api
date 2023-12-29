<?php

namespace App\Http\Controllers;

use App\Services\FavoriteService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoritesController extends Controller
{
    protected $favoriteService;

    /**
     * The function is a constructor that initializes the FavoriteService object and sets the middleware to
     * require authentication.
     * 
     * @param FavoriteService favoriteService The `` parameter is an instance of the
     * `FavoriteService` class. It is being injected into the constructor of the current class.
     */
    public function __construct(FavoriteService $favoriteService)
    {
        $this->middleware('auth');
        $this->favoriteService = $favoriteService;
    }

    /**
     * The `manage` function in PHP handles the management of user favorites, including adding a new
     * favorite and displaying the existing favorites.
     * 
     * @param Request request The  parameter is an instance of the Request class, which represents
     * an HTTP request made to the application. It contains information about the request such as the
     * request method, URL, headers, and any data sent with the request.
     * 
     * @return a redirect response if the request has a 'favoriteName' parameter. Otherwise, it returns a
     * view with the 'favorites' data.
     */
    public function manage(Request $request)
    {
        $user = Auth::user();

        if ($request->has('favoriteName')) {
            $favoriteName = $request->input('favoriteName');
            $result = $this->favoriteService->addToFavorites($user, $favoriteName);

            return redirect()->route('favorites')->with($result['type'], $result['message']);
        }

        $favorites = $user->favorites;

        return view('favorites', compact('favorites'));
    }

    /**
     * The destroy function deletes a summoner from the user's favorites and redirects to the favorites
     * page with a success message.
     * 
     * @param id The "id" parameter represents the ID of the summoner that needs to be deleted from the
     * user's favorites.
     * 
     * @return a redirect to the 'favorites' route with a success message.
     */
    public function destroy($id)
    {
        $user = Auth::user();
        $user->favorites()->where('id', $id)->delete();
        return redirect()->route('favorites')->with('success', 'Summoner deleted from favorites.');
    }
}
