<?php

namespace App\Http\Controllers;

use App\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller {

	public function __construct() {
		$this->middleware( 'auth' );
	}


	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
//    	dump(Auth::user()->id);

		$tasks = Auth::user()->tasks;

		return $tasks;
//    	dd( $tasks);

//	    return view('home');
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function store( Request $request ) {
		$this->validate( $request, [
			'title' => 'required'
		], [
			'title.required' => 'Please enter title~!'
		] );

		$title   = $request->input( 'title' );
		$user_id = $request->user()->id;
		$task    = Task::create( [
			"user_id"   => $user_id,
			"title"     => $title,
			"completed" => 0,
		] );
		if ( $task->save() ) {
			return $task->toJson();
		} else {
			return 0;
		}


	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Task $task
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function show( Task $task ) {
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Task $task
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function edit( Task $task ) {
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  \App\Task $task
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function update( Request $request, Task $task ) {
		$is_completed = $request->input( 'is_completed' );
		$title        = $request->input( 'title' );

		$task->update( [
			"completed" => $is_completed,
			"title"     => $title
		] );
		if ( $task->save() ) {
			return 1;
		} else {
			return 0;
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Task $task
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function destroy( Task $task ) {
		//
//	    dd('delted');

		if ( $task->delete() ) {
//		    return   Auth::user()->tasks;;

			return $task;
		} else {
			return 0;
		}

	}
}
