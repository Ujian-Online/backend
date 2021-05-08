<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\SoalPaketDataTable;
use App\Http\Controllers\Controller;
use App\Sertifikasi;
use App\SoalPaket;
use App\SoalPaketItem;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class SoalPaketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param SoalPaketDataTable $dataTables
     *
     * @return mixed
     */
    public function index(SoalPaketDataTable $dataTables)
    {
        // return index data with datatables services
        return $dataTables->render('layouts.pageTable', [
            'title' => 'Soal Paket Lists',
            'filter_route' => route('admin.soal.paket.index'),
            'filter_view' => 'admin.soal.filter-form'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|Response|View
     */
    public function create()
    {
        // return view template create
        return view('admin.soal.paket-form', [
            'title'         => 'Tambah Soal Paket Baru',
            'action'        => route('admin.soal.paket.store'),
            'isCreated'     => true,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        // validate input
        $request->validate([
            'title'             => 'required',
            'durasi_ujian'      => 'required|min:1|max:1440',
            'sertifikasi_id'    => 'required',
        ]);

        // get form data
        $dataInput = $request->only([
            'title',
            'durasi_ujian',
            'sertifikasi_id',
        ]);

        // get user login (asesor)
        $user = $request->user();
        if($user->can('isAssesor')) {
            $dataInput['asesor_id'] = $user->id;
        }

        // save to database
        $query = SoalPaket::create($dataInput);

        // get input soal_pilihanganda_id
        $soal_pilihangandas = $request->input('soal_pilihanganda_id');
        // get input soal_essay_id
        $soal_essays = $request->input('soal_essay_id');
        // variable for soal paket item
        $soal_paket_items = [];

        // loop soal pilihan ganda
        if(isset($soal_pilihangandas) and !empty($soal_pilihangandas)) {
            foreach($soal_pilihangandas as $soal_pilihanganda) {

                // validate soal based on sertifikasi id
                if(soal_validate($soal_pilihanganda, null, $dataInput['sertifikasi_id'])) {
                    $soal_paket_items[] = [
                        'soal_paket_id' => $query->id,
                        'soal_id' => $soal_pilihanganda,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }

            }
        }

        // loop soal essay
        if(isset($soal_essays) and !empty($soal_essays)) {
            foreach($soal_essays as $soal_essay) {

                // validate soal based on sertifikasi id
                if(soal_validate($soal_essay, null, $dataInput['sertifikasi_id'])) {
                    $soal_paket_items[] = [
                        'soal_paket_id' => $query->id,
                        'soal_id' => $soal_essay,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }

            }
        }

        // bulk insert soal paket item
        SoalPaketItem::insert($soal_paket_items);

        // redirect to index table
        return redirect()
            ->route('admin.soal.paket.index')
            ->with('success', trans('action.success', [
                'name' => $query->title
            ]));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return Application|Factory|Response|View
     */
    public function show(int $id)
    {
        // Find Data by ID
        $query = SoalPaket::with([
                'soalpaketitem',
                'soalpaketitem.soal',
                'soalpaketitem.soal.soalpilihanganda'
        ]) ->findOrFail($id);
        $soal_pilihangandas = [];
        $soal_essays = [];

        // extract soal pilihanganda and essay from soalpaketitem if found
        if(isset($query->soalpaketitem) and !empty($query->soalpaketitem)) {
            foreach($query->soalpaketitem as $soalpaketitem) {
                if(isset($soalpaketitem->soal) and !empty($soalpaketitem->soal)) {
                    if($soalpaketitem->soal->question_type == 'multiple_option') {
                        $soal_pilihangandas[] = $soalpaketitem->soal;
                    } else {
                        $soal_essays[] = $soalpaketitem->soal;
                    }
                }
            }
        }

        // return data to view
        return view('admin.soal.paket-form', [
            'title'         => 'Tampilkan Detail: ' . $query->title,
            'action'        => '#',
            'isShow'        => route('admin.soal.paket.edit', $id),
            'query'         => $query,
            'soal_pilihangandas'    => $soal_pilihangandas,
            'soal_essays'           => $soal_essays,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return Application|Factory|Response|View
     */
    public function edit(int $id)
    {
        // Find Data by ID
        $query = SoalPaket::with([
            'soalpaketitem',
            'soalpaketitem.soal',
            'soalpaketitem.soal.soalpilihanganda'
        ]) ->findOrFail($id);
        $soal_pilihangandas = [];
        $soal_essays = [];

        // extract soal pilihanganda and essay from soalpaketitem if found
        if(isset($query->soalpaketitem) and !empty($query->soalpaketitem)) {
            foreach($query->soalpaketitem as $soalpaketitem) {
                if(isset($soalpaketitem->soal) and !empty($soalpaketitem->soal)) {
                    if($soalpaketitem->soal->question_type == 'multiple_option') {
                        $soal_pilihangandas[] = $soalpaketitem->soal;
                    } else {
                        $soal_essays[] = $soalpaketitem->soal;
                    }
                }
            }
        }

        // return data to view
        return view('admin.soal.paket-form', [
            'title'         => 'Ubah Data: ' . $query->title,
            'action'        => route('admin.soal.paket.update', $id),
            'isEdit'        => true,
            'query'         => $query,
            'soal_pilihangandas'    => $soal_pilihangandas,
            'soal_essays'           => $soal_essays,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int     $id
     *
     * @return RedirectResponse
     */
    public function update(Request $request, int $id)
    {
        // validate input
        $request->validate([
            'title'             => 'required',
            'durasi_ujian'      => 'required|min:1|max:1440',
            'sertifikasi_id'    => 'required',
        ]);

        // get form data
        $dataInput = $request->only([
            'title',
            'durasi_ujian',
            'sertifikasi_id',
        ]);

        // get user login (asesor)
        $user = $request->user();
        if($user->can('isAssesor')) {
            $dataInput['asesor_id'] = $user->id;
        }

        // find by id and update
        $query = SoalPaket::findOrFail($id);
        // update data
        $query->update($dataInput);

        // destroy old data in soalpaketitem
        SoalPaketItem::where('soal_paket_id', $id)->delete();

        // get input soal_pilihanganda_id
        $soal_pilihangandas = $request->input('soal_pilihanganda_id');
        // get input soal_essay_id
        $soal_essays = $request->input('soal_essay_id');
        // variable for soal paket item
        $soal_paket_items = [];

        // loop soal pilihan ganda
        if(isset($soal_pilihangandas) and !empty($soal_pilihangandas)) {
            foreach($soal_pilihangandas as $soal_pilihanganda) {

                // validate soal based on sertifikasi id
                if(soal_validate($soal_pilihanganda, null, $dataInput['sertifikasi_id'])) {
                    $soal_paket_items[] = [
                        'soal_paket_id' => $query->id,
                        'soal_id' => $soal_pilihanganda,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }

            }
        }

        // loop soal essay
        if(isset($soal_essays) and !empty($soal_essays)) {
            foreach($soal_essays as $soal_essay) {

                // validate soal based on sertifikasi id
                if(soal_validate($soal_essay, null, $dataInput['sertifikasi_id'])) {
                    $soal_paket_items[] = [
                        'soal_paket_id' => $query->id,
                        'soal_id' => $soal_essay,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }

            }
        }

        // bulk insert soal paket item
        SoalPaketItem::insert($soal_paket_items);

        // redirect
        return redirect()
            ->route('admin.soal.paket.index')
            ->with('success', trans('action.success_update', [
                'name' => $query->title
            ]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(int $id): JsonResponse
    {
        $query = SoalPaket::findOrFail($id);
        $query->delete();

        // return response json if success
        return response()->json([
            'code' => 200,
            'success' => true,
        ]);
    }

    /**
     * Select2 Search Data
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function search(Request $request)
    {
        // database query
        $query = new SoalPaket();
        // result variable
        $result = [];

        // get input from select2 search term
        $q = $request->input('q');
        // sertifikasi id search
        $sertifikasi_id = $request->input('sertifikasi_id');

        // check if query is numeric or not
        if(is_numeric($q)) {
            $query = $query->where('id', 'like', "%$q%");
        } else {
            $query = $query->where('title', 'like', "%$q%");
        }

        if(!empty($sertifikasi_id)) {
            $query = $query->where('sertifikasi_id', $sertifikasi_id);
        }

        // limit search soal paket by asesor id if search by assesor
        $user = $request->user();
        if($user->can('isAssesor')) {
            $query = $query->where('asesor_id', $user->id);
        }

        // check if data found or not
        if($query->count() != 0) {
            foreach($query->get() as $data) {
                $result[] = [
                    'id' => $data->id,
                    'text' => '[ID: ' . $data->id . '] - ' . $data->title,
                ];
            }
        }

        // response result
        return response()->json($result, 200);
    }
}
