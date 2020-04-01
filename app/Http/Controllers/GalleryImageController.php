<?php

namespace App\Http\Controllers;

use App\Http\Requests\GalleryImage\CreateGalleryImageRequest;
//use App\Http\Requests\GalleryImage\UpdateGalleryImageRequest;
use App\Http\Resources\GalleryImageResource;
use Illuminate\Support\Facades\Auth;
use Image;
use Illuminate\Support\Facades\Gate;
use Illuminate\Auth\Access\AuthorizationException;

use App\GalleryImage;

class GalleryImageController extends Controller
{

    protected $path;
    function __construct()
    {
        $this->path = public_path('images/gallery/');
        $this->user = Auth::user();
    }

    public function index()
    {
        $galleryImages=$this->user->page->galleryImages;
        return GalleryImageResource::collection($galleryImages);
    }

    public function store(CreateGalleryImageRequest $request)
    {
        $image = $request->file('photo');
        $countRequest = count($request->file('photo'));

        for($i=0; $i < $countRequest; $i++ ){
            $filename = mt_rand(111111111,999999999). '.' .$image[$i]->getClientOriginalExtension();
            $path = $this->path.$filename;
            $page=$this->user->page;
            Image::make($image[$i]->getRealPath())->save($path);
            $page->galleryImages()->save(
                new GalleryImage(
                    [
                        'photo' =>$filename,
                    ]
                )
            );
        }
        return $this->index();
    }

    public function destroy(GalleryImage $galleryImage)
    {
        if($galleryImage->page_id == $this->user->page->id){
            $galleryImage->delete();
        }
        return new GalleryImageResource($galleryImage);
    }
}
