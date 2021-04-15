<?php

namespace App\Http\Controllers\Admin;

use App\AsesiSertifikasiUnitKompetensiElement;
use App\AsesiUnitKompetensiDokumen;
use App\DataTables\Admin\AsesiUnitKompetensiDokumenDataTable;
use App\Http\Controllers\Controller;
use App\Order;
use App\Sertifikasi;
use App\SertifikasiUnitKompentensi;
use App\SertifikasiUnitKompetensiElement;
use App\User;
use App\UserAsesi;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class AsesiUnitKompetensiDokumenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param AsesiUnitKompetensiDokumenDataTable $dataTables
     *
     * @return mixed
     */
    public function index(AsesiUnitKompetensiDokumenDataTable $dataTables)
    {
        // return index data with datatables services
        return $dataTables->render('layouts.pageTable', [
            'title' => 'Asesi APL-02 Lists',
            'filter_route'  => route('admin.asesi.apl02.index'),
            'filter_view'   => 'admin.assesi.apl02filter-form',
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|Response|View
     */
    public function create()
    {
        // get unit kompetensi lists
        $unitkompentensis = SertifikasiUnitKompentensi::all();
        // get sertifikasi lists
        $sertifikasis = Sertifikasi::all();

        // return view template create
        return view('admin.assesi.apl02-form', [
            'title'             => 'Tambah Asesi APL-02',
            'action'            => route('admin.asesi.apl02.store'),
            'isCreated'         => true,
            'unitkompentensis'  => $unitkompentensis,
            'sertifikasis'      => $sertifikasis,
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
            'asesi_id'              => 'required',
            'unit_kompetensi_id'    => 'required',
            'sertifikasi_id'        => 'required',
        ]);

        // get form data
        $dataInput = $request->only([
            'asesi_id',
            'unit_kompetensi_id',
            'sertifikasi_id',
        ]);

        // Copy Snapshot From Sertifikasi Unit Kompetensi
        $sertifikasiUK = SertifikasiUnitKompentensi::where('id', $dataInput['unit_kompetensi_id'])
                    ->where('sertifikasi_id', $dataInput['sertifikasi_id'])->firstOrFail();

        // update input from index data to snapshot
        $dataInput['order'] = $sertifikasiUK->order;
        $dataInput['kode_unit_kompetensi'] = $sertifikasiUK->kode_unit_kompetensi;
        $dataInput['title'] = $sertifikasiUK->title;
        $dataInput['sub_title'] = $sertifikasiUK->sub_title;

        // save to database
        $query = AsesiUnitKompetensiDokumen::create($dataInput);

        // Copy Snapshot From SertifikasiUnitKompetensiElement to AsesiSertifikasiUnitKompetensiElement
        $sertifikasiUKElements = SertifikasiUnitKompetensiElement::where('unit_kompetensi_id', $dataInput['unit_kompetensi_id'])->get();

        // loop data and change date to now
        $asesiUKElements = [];
        foreach($sertifikasiUKElements as $sertifikasiUKElement) {
            $asesiUKElements[] = [
                'asesi_id' => $dataInput['asesi_id'],
                'unit_kompetensi_id' => $sertifikasiUKElement->unit_kompetensi_id,
                'desc' => $sertifikasiUKElement->desc,
                'upload_instruction' => $sertifikasiUKElement->upload_instruction,
                'is_verified' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // bulk insert snapshot
        AsesiSertifikasiUnitKompetensiElement::insert($asesiUKElements);

        // redirect to index table
        return redirect()
            ->route('admin.asesi.apl02.index')
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
        $query = AsesiUnitKompetensiDokumen::findOrFail($id);
        // get unit kompetensi lists
        $unitkompentensis = SertifikasiUnitKompentensi::all();
        // get sertifikasi lists
        $sertifikasis = Sertifikasi::all();

        // return data to view
        return view('admin.assesi.apl02-form', [
            'title'             => 'Detail Asesi APL-02: ' . $query->title,
            'action'            => '#',
            'isShow'            => route('admin.asesi.apl02.edit', $id),
            'query'             => $query,
            'unitkompentensis'  => $unitkompentensis,
            'sertifikasis'      => $sertifikasis,
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
        $query = AsesiUnitKompetensiDokumen::findOrFail($id);
        // get unit kompetensi lists
        $unitkompentensis = SertifikasiUnitKompentensi::all();
        // get sertifikasi lists
        $sertifikasis = Sertifikasi::all();

        // return data to view
        return view('admin.assesi.apl02-form', [
            'title'             => 'Ubah Asesi APL-02: ' . $query->id,
            'action'            => route('admin.asesi.apl02.update', $id),
            'isEdit'            => true,
            'query'             => $query,
            'unitkompentensis'  => $unitkompentensis,
            'sertifikasis'      => $sertifikasis,
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
            'asesi_id'              => 'required',
            'unit_kompetensi_id'    => 'required',
            'order'                 => 'required',
            'sertifikasi_id'        => 'required',
            'kode_unit_kompetensi'  => 'required',
            'title'                 => 'required',
        ]);

        // get form data
        $dataInput = $request->only([
            'asesi_id',
            'unit_kompetensi_id',
            'order',
            'sertifikasi_id',
            'kode_unit_kompetensi',
            'title',
            'sub_title',
        ]);

        // find by id and update
        $query = AsesiUnitKompetensiDokumen::findOrFail($id);
        // update data
        $query->update($dataInput);

        // redirect
        return redirect()
            ->route('admin.asesi.apl02.index')
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
        $query = AsesiUnitKompetensiDokumen::findOrFail($id);
        $query->delete();

        // return response json if success
        return response()->json([
            'code' => 200,
            'success' => true,
        ]);
    }

    /**
     * APL-02 View Function
     *
     * @param Request $request
     * @param int $userid
     * @param int $sertifikasiid
     * @return Application|Factory|View
     */
    public function apl02View(Request $request, int $userid, int $sertifikasiid)
    {
        // cek apakah yang login itu asesor atau admin
        $whoLogin = request()->user();
        // get user asesi detail
        $user = User::with('asesi')->where('id', $userid)->firstOrFail();
        // get sertifikasi detail
        $sertifikasi = Sertifikasi::findOrFail($sertifikasiid);
        // get UK Dokumen and Element
        $unitkompetensis = AsesiUnitKompetensiDokumen::with([
                'asesisertifikasiunitkompetensielement' => function ($query) use ($userid) {
                    $query->where('asesi_id', $userid);
                },
                'asesisertifikasiunitkompetensielement.media' => function ($query) use ($user) {
                    $query->where('asesi_id', $user->id);
                }
            ])
            ->when($whoLogin, function($query) use ($whoLogin) {
                if($whoLogin->type == 'assesor') {
                    $query->join('ujian_asesi_asesors', function ($join) {
                        $join->on('ujian_asesi_asesors.asesi_id', '=', 'asesi_unit_kompetensi_dokumens.asesi_id');
                        $join->on('ujian_asesi_asesors.sertifikasi_id', '=', 'asesi_unit_kompetensi_dokumens.sertifikasi_id');
                    })
                    ->where('ujian_asesi_asesors.asesor_id', $whoLogin->id);
                }
            })
            ->where('asesi_unit_kompetensi_dokumens.asesi_id', $userid)
            ->where('asesi_unit_kompetensi_dokumens.sertifikasi_id', $sertifikasiid)
            ->get();

        // return error if data not found
        if(count($unitkompetensis) == 0) {
            abort(404);
        }

        // get name from asesi object
        $name = $user->email;
        if(isset($user->asesi) and !empty($user->asesi) and !empty($user->asesi->name)) {
            $name = $user->asesi->name;
        }

        // print mode
        $printMode = $request->input('print') ? true : false;

        // get order detail
        $order = Order::where('asesi_id', $userid)
            ->where('sertifikasi_id', $sertifikasiid)
            ->orderBy('transfer_date', 'desc')
            ->first();
        // get tuk detail based on order
        $tuk = (isset($order) & !empty($order)) ? $order->tuk : null;

        // return data to view
        return view($printMode ?  'admin.assesi.apl02-print' : 'admin.assesi.apl02-view', [
            'title'             => 'Detail Asesi APL-02: ' . $name,
            'action'            => '#',
            'isShow'            => route('admin.asesi.apl02.viewedit', [
                'userid'        => $userid,
                'sertifikasiid' => $sertifikasiid
            ]),
            'printMode'         => $printMode,
            'user'              => $user,
            'sertifikasi'       => $sertifikasi,
            'unitkompetensis'   => $unitkompetensis,
            'order'             => $order,
            'tuk'               => $tuk,
        ]);
    }

    /**
     * APL-02 View Edit Function
     *
     * @param Request $request
     * @param int $userid
     * @param int $sertifikasiid
     * @return Application|Factory|View
     */
    public function apl02ViewEdit(Request $request, int $userid, int $sertifikasiid)
    {
        // cek apakah yang login itu asesor atau admin
        $whoLogin = request()->user();
        // get user asesi detail
        $user = User::with('asesi')->findOrFail($userid);
        // get sertifikasi detail
        $sertifikasi = Sertifikasi::findOrFail($sertifikasiid);
        // get UK Dokumen and Element
        $unitkompetensis = AsesiUnitKompetensiDokumen::with([
                'asesisertifikasiunitkompetensielement' => function ($query) use ($userid) {
                    $query->where('asesi_id', $userid);
                },
                'asesisertifikasiunitkompetensielement.media' => function ($query) use ($user) {
                    $query->where('asesi_id', $user->id);
                }
            ])
            ->when($whoLogin, function($query) use ($whoLogin) {
                if($whoLogin->type == 'assesor') {
                    $query->join('ujian_asesi_asesors', function ($join) {
                        $join->on('ujian_asesi_asesors.asesi_id', '=', 'asesi_unit_kompetensi_dokumens.asesi_id');
                        $join->on('ujian_asesi_asesors.sertifikasi_id', '=', 'asesi_unit_kompetensi_dokumens.sertifikasi_id');
                    })
                    ->where('ujian_asesi_asesors.asesor_id', $whoLogin->id);
                }
            })
            ->where('asesi_unit_kompetensi_dokumens.asesi_id', $userid)
            ->where('asesi_unit_kompetensi_dokumens.sertifikasi_id', $sertifikasiid)
            ->get();

        // return error if data not found
        if(count($unitkompetensis) == 0) {
            abort(404);
        }

        // get name from asesi object
        $name = $user->email;
        if(isset($user->asesi) and !empty($user->asesi)) {
            $name = $user->asesi->name;
        }

        // return data to view
        return view('admin.assesi.apl02-view', [
            'title'             => 'Detail Asesi APL-02: ' . $name,
            'action'            => route('admin.asesi.apl02.viewupdate', [
                'userid'        => $userid,
                'sertifikasiid' => $sertifikasiid
            ]),
            'isEdit'            => true,
            'user'              => $user,
            'sertifikasi'       => $sertifikasi,
            'unitkompetensis'   => $unitkompetensis,
        ]);
    }

    /**
     * APL-02 Update Function
     *
     * @param Request $request
     * @param int $userid
     * @param int $sertifikasiid
     * @return RedirectResponse
     */
    public function apl02ViewUpdate(Request $request, int $userid, int $sertifikasiid)
    {
        $request->validate([
            'ukelement' => 'required|array'
        ]);

        // cek apakah yang login itu asesor atau admin
        $whoLogin = request()->user();
        // cek data apakah yg update asesor atau admin
        $unitkompetensis = AsesiUnitKompetensiDokumen::when($whoLogin, function($query) use ($whoLogin) {
                if($whoLogin->type == 'assesor') {
                    $query->join('ujian_asesi_asesors', function ($join) {
                        $join->on('ujian_asesi_asesors.asesi_id', '=', 'asesi_unit_kompetensi_dokumens.asesi_id');
                        $join->on('ujian_asesi_asesors.sertifikasi_id', '=', 'asesi_unit_kompetensi_dokumens.sertifikasi_id');
                    })
                        ->where('ujian_asesi_asesors.asesor_id', $whoLogin->id);
                }
            })
            ->where('asesi_unit_kompetensi_dokumens.asesi_id', $userid)
            ->where('asesi_unit_kompetensi_dokumens.sertifikasi_id', $sertifikasiid)
            ->first();

        // return error if data not found
        if(!$unitkompetensis) {
            abort(404);
        }

        // get uk element data
        $ukelements = $request->input('ukelement');
        // check if uk element empty or not
        if(!empty($ukelements)) {
            // loop uk element id to get id
            foreach($ukelements['id'] as $ukelement) {
                $uk_id = $ukelement;
                // is_verified by id
                $is_verified = $ukelements['is_verified'][$uk_id];
                // verification note by id
                $verification_note = $ukelements['verification_note'][$uk_id];

                // run update query by each id
                AsesiSertifikasiUnitKompetensiElement::select(['is_verified', 'verification_note'])
                    ->where('id', $uk_id)
                    ->where('asesi_id', $userid)
                    ->update([
                        'is_verified' => $is_verified,
                        'verification_note' => $verification_note,
                    ]);
            }
        }


        // get user asesi detail
        $user = User::with('asesi')->findOrFail($userid);

        // get name from asesi object
        $name = $user->email;
        if(isset($user->asesi) and !empty($user->asesi)) {
            $name = $user->asesi->name;
        }

        // redirect
        return redirect()
            ->route('admin.asesi.apl02.index')
            ->with('success', trans('action.success_update', [
                'name' => $name
            ]));
    }
}
