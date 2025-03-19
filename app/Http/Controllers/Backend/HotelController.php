<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\{Hotel, Conference};
use Illuminate\Http\Request;
use Exception, Storage, Image, Str;

class HotelController extends Controller
{
    public function index()
    {
        $latestConference = Conference::latestConference();
        $hotels = Hotel::where(['conference_id' => $latestConference->id, 'status' => 1])->latest()->get();
        return view('backend.hotels.show', compact('hotels'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.hotels.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $rules = [
                'name' => 'required|unique:hotels,name',
                'address' => 'required',
                'contact_person' => 'nullable',
                'phone' => 'nullable',
                'email' => 'nullable|email',
                'rating' => 'nullable',
                'featured_image' => 'nullable|mimes:jpg,png',
                'pics' => 'nullable',
                'pics.*' => 'mimes:jpg,png',
                'room_type' => 'nullable',
                'description' => 'nullable',
                'google_map' => 'nullable',
                'price' => 'nullable',
                'website' => 'nullable|url',
                'facility' => 'nullable',
                'promo_code' => 'nullable',
            ];

            $validated = $request->validate($rules);

            if (!empty($validated['pics']) && count($validated['pics']) > 4) {
                return redirect()->back()->withInput()->with('delete', 'Images Limitation Crossed.');
            }

            $validated['slug'] = Str::slug($validated['name']);

            if (!empty($validated['featured_image'])) {
                $fileName = time() . '.' . $validated['featured_image']->getClientOriginalExtension();
                $image = Image::make($validated['featured_image']);

                $image->fit(400, 400, function ($constraint) {
                    $constraint->upsize();
                })->encode('jpg');

                Storage::put("public/hotel/featured-image/{$fileName}", $image);
                $validated['featured_image'] = $fileName;
            }

            if (!empty($validated['pics'])) {
                foreach ($validated['pics'] as $key => $pic) {
                    // dump($key);
                    $filesName = rand(00, 99) . time() . '.' . $pic->getClientOriginalExtension();
                    $thumbnailImage = Image::make($pic);
                    $largeImage = Image::make($pic);

                    $thumbnailImage->fit(1280, 720, function ($constraint) {
                        $constraint->upsize();
                    })->encode('jpg');

                    $largeImage->resize(1680, 820, function($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })->encode('jpg');

                    Storage::put("public/hotel/images/thumbnail/{$filesName}", $thumbnailImage);
                    Storage::put("public/hotel/images/large/{$filesName}", $largeImage);

                    $validated['images'][] = [
                        'fileName' => $filesName,
                        'room_type' => $validated['room_type'][$key]
                    ];
                }
            }
            $latestConference = Conference::latestConference();
            $validated['conference_id'] = $latestConference->id;

            Hotel::create($validated);

            return redirect()->route('hotel.index')->with('status', 'Hotel Added Successfully');

        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Hotel $hotel)
    {
        return view('backend.hotels.create', compact('hotel'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Hotel $hotel)
    {
        try {
            $rules = [
                'name' => 'required|unique:hotels,name,'.$hotel->id,
                'address' => 'required',
                'contact_person' => 'nullable',
                'phone' => 'nullable',
                'email' => 'nullable|email',
                'rating' => 'nullable',
                'featured_image' => 'nullable|mimes:jpg,png',
                'pics' => 'nullable',
                'pics.*' => 'mimes:jpg,png',
                'room_type' => 'nullable',
                'room_type_old' => 'nullable',
                'description' => 'nullable',
                'google_map' => 'nullable',
                'price' => 'nullable',
                'website' => 'nullable|url',
                'facility' => 'nullable',
                'promo_code' => 'nullable',
            ];

            $validated = $request->validate($rules);

            $countOldImages = 0;
            if (!empty($hotel->images)) {
                $countOldImages = count($hotel->images);
            }
            if (!empty($validated['pics']) && count($validated['pics']) + $countOldImages > 4) {
                return redirect()->back()->withInput()->with('delete', 'Images Limitation Crossed.');
            }

            $validated['slug'] = Str::slug($validated['name']);

            if (!empty($validated['featured_image'])) {
                Storage::delete("public/hotel/featured-image/{$hotel->featured_image}");
                $fileName = time() . '.' . $validated['featured_image']->getClientOriginalExtension();
                $image = Image::make($validated['featured_image']);

                $image->fit(400, 400, function ($constraint) {
                    $constraint->upsize();
                })->encode('jpg');

                Storage::put("public/hotel/featured-image/{$fileName}", $image);
                $validated['featured_image'] = $fileName;
            }

            $newImages = [];
            $oldImages = [];
            if (!empty($hotel->images)) {
                $oldImages = $hotel->images;
                foreach ($oldImages as $k => $v) {
                    $oldImages[$k]['room_type'] = $validated['room_type_old'][$k];
                }
            }
            if (!empty($validated['pics'])) {
                foreach ($validated['pics'] as $key => $pic) {
                    $filesName = rand(00, 99) . time() . '.' . $pic->getClientOriginalExtension();
                    $thumbnailImage = Image::make($pic);
                    $largeImage = Image::make($pic);

                    $thumbnailImage->fit(1280, 720, function ($constraint) {
                        $constraint->upsize();
                    })->encode('jpg');

                    $largeImage->resize(1680, 820, function($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })->encode('jpg');

                    Storage::put("public/hotel/images/thumbnail/{$filesName}", $thumbnailImage);
                    Storage::put("public/hotel/images/large/{$filesName}", $largeImage);

                    $newImage  = [
                        'fileName' => $filesName,
                        'room_type' => $validated['room_type'][$key]
                    ];

                    $newImages[] = $newImage;
                }
            }
            $validated['images'] = array_merge($oldImages, $newImages);

            $hotel->update($validated);

            return redirect()->route('hotel.index')->with('status', 'Hotel Updated Successfully');
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Hotel $hotel)
    {
        $hotel->update(['status' => 0]);

        return redirect()->route('hotel.index')->with('delete', 'Hotel Deleted Successfully');
    }

    public function deleteImage(Hotel $hotel, string $img)
    {
        Storage::delete("public/hotel/images/thumbnail/{$img}");
        Storage::delete("public/hotel/images/large/{$img}");

        $images = $hotel->images;

        if (count($hotel->images) == 1) {
            $hotel->update(['images' => null]);
        } else {
            foreach ($images as $key => $value) {
                if ($value['fileName'] == $img) {
                    unset($images[$key]);
                    break;
                }
            }
            $images = array_values($images);
            $hotel->update(['images' => $images]);
        }

        return redirect()->back()->with('delete', 'Image Deleted Successfully');
    }

    public function changeStatus(Hotel $hotel)
    {
        if ($hotel->visible_status == 1) {
            $status = 0;
        } else {
            $status = 1;
        }

        $hotel->update(['visible_status' => $status]);

        return redirect()->back()->with('status', 'Hotel featured status changed successfully.');
    }
}
