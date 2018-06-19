<?php

	namespace App\Http\Controllers;

	use Illuminate\Http\Request;
	use App\Kiosk;
	use App\Review;
	use DB;
	use Illuminate\Support\Facades\Storage;

	class KiosksController extends Controller {
		/**
		 * Create a new controller instance.
		 *
		 * @return void
		 */
		public function __construct() {
			$this -> middleware('auth', ['except' => ['index', 'show']]);
		}

		/**
		 * Display a listing of the resource.
		 *
		 * @return \Illuminate\Http\Response
		 */
		public function index() {
			$kiosks = Kiosk ::orderBy('created_at', 'desc') -> paginate(10);
			return view('kiosks.index') -> with('kiosks', $kiosks);
		}

		/**
		 * Store a newly created Review in storage.
		 *
		 * @param  \Illuminate\Http\Request $request
		 * @return \Illuminate\Http\Response
		 */
		public function storeReview(Request $request) {
			$this -> validate($request, [
				'title' => 'required|max:30',
				'stars' => 'required|between:0,5|integer',
				'body' => 'nullable'
			]);

			if (count(Review ::where('kiosk_id', $request -> kiosk_id) -> where('user_id', auth() -> user() -> id) -> get()) > 0) {
				return redirect('/kiosks/'.$request -> kiosk_id) -> with('error', 'Sie haben diesen Kiosk bereits bewertet');
			}

			//Create Kiosk
			$review = new Review;
			$review -> title = $request -> title;
			$review -> body = $request -> body;
			$review -> stars = $request -> stars;
			$review -> user_id = auth() -> user() -> id;
			$review -> kiosk_id = $request -> kiosk_id;
			$review -> save();

			return redirect('/kiosks/'.$request -> kiosk_id) -> with('success', 'Rezension erstellt');
		}

		/**
		 * Remove the specified review from storage.
		 *
		 * @param  int $id
		 * @return \Illuminate\Http\Response
		 */
		public function destroyReview($id) {
			$review = Review ::where('kiosk_id', $id) -> where('user_id', auth() -> user() -> id) -> get() -> first();

			//Check for correct user
			if (auth() -> user() -> id !== $review -> user_id) {
				return redirect('/kiosks') -> with('error', 'Nicht autorisierte Seite');
			}

			$review -> delete();
			return redirect('/kiosks/'.$id) -> with('success', 'Rezension gelöscht');
		}

		/**
		 * Show the form for creating a new resource.
		 *
		 * @return \Illuminate\Http\Response
		 */
		public function create() {
			return view('kiosks.create');
		}

		/**
		 * Store a newly created resource in storage.
		 *
		 * @param  \Illuminate\Http\Request $request
		 * @return \Illuminate\Http\Response
		 */
		public function store(Request $request) {
			$this -> validate($request, [
				'name' => 'required',
				'info' => 'required',
				'latitude' => 'required|numeric',
				'longitude' => 'required|numeric',
				'picture' => 'image|nullable|max:1999' //Must be an image, Mustn't be there, size have to be under 2000MB
			]);

			//Handle File Upload
			if ($request -> hasFile('picture')) {
				//Get filename with the extension
				$filenameWithExt = $request -> file('picture') -> getClientOriginalName();
				//Get just filename
				$filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
				//Get just extension
				$extension = $request -> file('picture') -> getClientOriginalExtension();
				//Filename to store
				$fileNameToStore = $filename.'_'.time().'.'.$extension;
				//Upload Image
				$path = $request -> file('picture') -> storeAs('public/pictures', $fileNameToStore);
			}
			else {
				$fileNameToStore = 'noimage.jpg';
			}

			//Create Kiosk
			$kiosk = new Kiosk;
			$kiosk -> admin_id = auth() -> user() -> id;
			$kiosk -> name = $request -> input('name');
			$kiosk -> info = $request -> input('info');
			$kiosk -> picture = $fileNameToStore;
			$kiosk -> longitude = $request -> input('longitude');
			$kiosk -> latitude = $request -> input('latitude');
			$kiosk -> save();

			return redirect('/kiosks') -> with('success', 'Kiosk Created');
		}

		/**
		 * Display the specified resource.
		 *
		 * @param  int $id
		 * @return \Illuminate\Http\Response
		 */
		public function show($id) {
			$kiosk = Kiosk ::find($id);
			$reviews = $reviews = Review ::where('kiosk_id', $id) -> orderBy('updated_at', 'asc') -> get();
			$starSum = 0;
			$stars = 0;

			if (count($reviews) != 0) {
				foreach ($reviews as $review) {
					$starSum += $review -> stars;
				}

				$stars = ($starSum / count($reviews));
			}

			return view('kiosks.show', ['kiosk' => $kiosk, 'reviews' => $reviews, 'stars' => $stars]);
		}

		/**
		 * Show the form for editing the specified resource.
		 *
		 * @param  int $id
		 * @return \Illuminate\Http\Response
		 */
		public function edit($id) {
			$kiosk = Kiosk ::find($id);

			//Check for correct user
			if (auth() -> user() -> id !== $kiosk -> admin_id) {
				return redirect('/kiosks') -> with('error', 'Kein Zugriff!');
			}

			return view('kiosks.edit') -> with('kiosk', $kiosk);
		}

		/**
		 * Update the specified resource in storage.
		 *
		 * @param  \Illuminate\Http\Request $request
		 * @param  int $id
		 * @return \Illuminate\Http\Response
		 */
		public function update(Request $request, $id) {
			$this -> validate($request, [
				'name' => 'required',
				'info' => 'required',
				'latitude' => 'required|numeric',
				'longitude' => 'required|numeric',
				'picture' => 'image|nullable|max:1999' //Must be an image, Mustn't be there, size have to be under 2000MB
			]);

			//Handle File Upload
			if ($request -> hasFile('picture')) {
				//Get filename with the extension
				$filenameWithExt = $request -> file('picture') -> getClientOriginalName();
				//Get just filename
				$filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
				//Get just extension
				$extension = $request -> file('picture') -> getClientOriginalExtension();
				//Filename to store
				$fileNameToStore = $filename.'_'.time().'.'.$extension;
				//Upload Image
				$path = $request -> file('picture') -> storeAs('public/pictures', $fileNameToStore);
			}
			else {
				$fileNameToStore = Kiosk ::find($id) -> picture;
			}

			//Create Kiosk
			$kiosk = Kiosk ::find($id);
			$kiosk -> admin_id = auth() -> user() -> id;
			$kiosk -> name = $request -> input('name');
			$kiosk -> info = $request -> input('info');
			$kiosk -> picture = $fileNameToStore;
			$kiosk -> longitude = $request -> input('longitude');
			$kiosk -> latitude = $request -> input('latitude');
			$kiosk -> save();

			return redirect('/kiosks') -> with('success', 'Kiosk Created');
		}

		/**
		 * Remove the specified resource from storage.
		 *
		 * @param  int $id
		 * @return \Illuminate\Http\Response
		 */
		public function destroy($id) {
			$kiosk = Kiosk ::find($id);

			//Check for correct user
			if (auth() -> user() -> id !== $kiosk -> admin_id) {
				return redirect('/kiosks') -> with('error', 'Nicht autorisierte Seite');
			}

			if ($kiosk -> picture !== 'noimage.jpg') {
				//Delete Image
				Storage ::delete('public/pictures/'.$kiosk -> picture);
			}

			$kiosk -> delete();
			return redirect('/kiosks') -> with('success', 'Kiosk gelöscht');
		}
	}
