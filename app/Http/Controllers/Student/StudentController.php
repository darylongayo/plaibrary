<?php

namespace App\Http\Controllers\Student;
use App\Book;
use App\User;
use App\Reservation;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:student');
    }
    public function index(User $user)
    {   

        $books = Book::where('id', '>' , 0)->latest()->paginate(9);
        return view('student.index', compact('books'));
    }

    public function reserve(Reservation $reservation, Book $book){
        $book->book_quantity = $book->book_quantity-1;
        $reservation->status = 1;
        $reservation->student_name = Auth::user()->name;
        $reservation->book_id = request('book_id');
        $reservation->book_name = request('book_name');
        $book->save();
        $reservation->save();
        return redirect()->back()->with('success', 'Successfully reserve book: '. $book->book_name);
    }
}
