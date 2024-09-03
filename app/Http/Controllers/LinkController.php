<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateLinkRequest;
use App\Models\Link;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class LinkController extends Controller
{
    private $user;

    public function __construct() {
        $this->user = Auth::user();
    }
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $links = $this->user->links;

        return response(['links' => $links], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateLinkRequest $request)
    {
        $link = $this->user->links()->create([
            'url' => $request->url,
            
        ]);

        return response()->json(['link' => $link], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    /**
     * Redirect short url to the actual url
     *
     * @param string $uri
     * @throws NotFoundHttpException
     * @return RedirectResponse
     */
    public function redirect($uri){
        $link = Link::where('uri', $uri)->first();

        if(!$link){
            throw new NotFoundHttpException('The short url does not exist');
        }

        $link->increment('clicks');

        return redirect($link->url);
    }


    /**
     * Download QR Code image
     *
     * @return Response
     */
    public function downloadQrCode(Link $link) {

        $fileName = $link->uri . '.png';
        $headers = [
            'Content-Type' => 'image/png',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '.png"',
        ];
        return response()->streamDownload(function () use ($link) {
            $link->qrCode();
        }, $fileName . '.png', $headers);
        
    }
}
