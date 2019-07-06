<?php

namespace App\Http\Controllers;

use App\Http\Requests\API\CreateSolutionAPIRequest;
use App\Http\Requests\API\UpdateSolutionAPIRequest;
use App\Models\Solution;
use App\Repositories\SolutionRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Illuminate\Support\Facades\File;
use Response;

/**
 * Class SolutionController
 * @package App\Http\Controllers\API
 */

class SolutionAPIController extends AppBaseController
{
    /** @var  SolutionRepository */
    private $solutionRepository;

    public function __construct(SolutionRepository $solutionRepo)
    {
        $this->solutionRepository = $solutionRepo;
        $this->middleware('auth:api', ['except' => ['index']]);
    }

    /**
     * Display a listing of the Solution.
     * GET|HEAD /solutions
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $solutions = $this->solutionRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($solutions->toArray(), 'Solutions retrieved successfully');
    }

    public function gen_name($file){
        //creates unique file name
        $fileName = $file->getClientOriginalName();
        $fileName = pathinfo($fileName, PATHINFO_FILENAME);
        //just takes file extension
        $ext = $file->getClientOriginalExtension();
        //filename to store
        $fileToStore = md5(uniqid($fileName))  . '.' . $ext;

        return $fileToStore;
    }

    /**
     * Store a newly created Solution in storage.
     * POST /solutions
     *
     * @param CreateSolutionAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateSolutionAPIRequest $request)
    {
        $input = $request->except(['file', 'filesize', 'student_id']);



        $file = $request->file('file');
        $input['student_id'] = auth('api')->user()->id;
        //required if files from input exists
        if ($file) {

            $input['filesize'] = $file->getSize();
            $fileToStore = $this->gen_name($file);

            $file->move('files', $fileToStore);
            $input['file'] = $fileToStore;
        }

        $solution = $this->solutionRepository->create($input);

        return $this->sendResponse($solution->toArray(), 'Solution saved successfully');
    }

    /**
     * Display the specified Solution.
     * GET|HEAD /solutions/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Solution $solution */
        $solution = $this->solutionRepository->find($id);

        if (empty($solution)) {
            return $this->sendError('Solution not found');
        }

        return $this->sendResponse($solution->toArray(), 'Solution retrieved successfully');
    }

    /**
     * Update the specified Solution in storage.
     * PUT/PATCH /solutions/{id}
     *
     * @param int $id
     * @param UpdateSolutionAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateSolutionAPIRequest $request)
    {
        $input = $request->except(['file', 'filesize', 'student_id']);

        /** @var Solution $solution */
        $solution = $this->solutionRepository->find($id);

        if (empty($solution)) {
            return $this->sendError('Solution not found');
        }

        $file = $request->file('file');
        $input['student_id'] = auth('api')->user()->id;
        //required if files from input exists
        if ($file) {

            $input['filesize'] = $file->getSize();
            $fileToStore = $this->gen_name($file);

            $file->move('files', $fileToStore);
            $input['file'] = $fileToStore;
        }

        $solution = $this->solutionRepository->update($input, $id);

        return $this->sendResponse($solution->toArray(), 'Solution updated successfully');
    }

    /**
     * Remove the specified Solution from storage.
     * DELETE /solutions/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Solution $solution */
        $solution = $this->solutionRepository->find($id);

        if (empty($solution)) {
            return $this->sendError('Solution not found');
        }


        $solution->delete();

        if ($solution->file) {
            File::delete('files/'.$solution->file);
        }
        return $this->sendResponse($id, 'Solution deleted successfully');
    }









}
