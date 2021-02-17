<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\UjianJadwalDataTable;
use App\Http\Controllers\Controller;
use App\UjianJadwal;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class UjianJadwalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param UjianJadwalDataTable $dataTables
     *
     * @return mixed
     */
    public function index(UjianJadwalDataTable $dataTables)
    {
        // return index data with datatables services
        return $dataTables->render('layouts.pageTable', [
            'title' => 'Jadwal Ujian Lists'
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
        return view('admin.ujian.jadwal-form', [
            'title'         => 'Tambah Jadwal Ujian Baru',
            'action'        => route('admin.ujian.jadwal.store'),
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
            'tanggal'       => 'required|date',
            'title'         => 'required',
            'description'   => 'required',
        ]);

        // get form data
        $dataInput = $request->only([
            'tanggal',
            'title',
            'description',
        ]);

        // save to database
        $query = UjianJadwal::create($dataInput);

        // redirect to index table
        return redirect()
            ->route('admin.ujian.jadwal.index')
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
        $query = UjianJadwal::findOrFail($id);

        // return data to view
        return view('admin.ujian.jadwal-form', [
            'title'     => 'Tampilkan Detail: ' . $query->title,
            'action'    => '#',
            'isShow'    => route('admin.ujian.jadwal.edit', $id),
            'query'     => $query,
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
        $query = UjianJadwal::findOrFail($id);

        // return data to view
        return view('admin.ujian.jadwal-form', [
            'title'     => 'Ubah Data: ' . $query->title,
            'action'    => route('admin.ujian.jadwal.update', $id),
            'isEdit'    => true,
            'query'     => $query,
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
            'tanggal'       => 'required|date',
            'title'         => 'required',
            'description'   => 'required',
        ]);

        // get form data
        $dataInput = $request->only([
            'tanggal',
            'title',
            'description',
        ]);

        // find by id and update
        $query = UjianJadwal::findOrFail($id);
        // update data
        $query->update($dataInput);

        // redirect
        return redirect()
            ->route('admin.ujian.jadwal.index')
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
        $query = UjianJadwal::findOrFail($id);
        $query->delete();

        // return response json if success
        return response()->json([
            'code' => 200,
            'success' => true,
        ]);
    }

    /**
     * Ajax Search
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function search(Request $request)
    {
        // database query
        $query = new UjianJadwal();
        // result variable
        $result = [];

        // get input from select2 search term
        $q = $request->input('q');
        $date = $request->input('date');

        // check if query is numeric or not
        if(is_numeric($q)) {
            $query = $query->where('id', 'like', "%$q%");
        } else {
            $query = $query->where('title', 'like', "%$q%");
        }

        // date filter
        if(isset($date) and !empty($date)) {
            $datenow    = now()->toDateString();
            $query      = $query->where('tanggal', '>=', $datenow);
        }

        // check if data found or not
        if($query->count() != 0) {
            foreach($query->get() as $data) {
                $result[] = [
                    'id' => $data->id,
                    'text' => '[ID: ' . $data->id . '] - ' . $data->title . ' - Tanggal Ujian : ' . \Carbon\Carbon::parse($data->tanggal)->format('d/m/Y'),
                ];
            }
        }

        // response result
        return response()->json($result, 200);
    }
}
