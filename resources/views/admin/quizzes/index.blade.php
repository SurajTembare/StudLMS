@extends('admin.master')

@section('title', 'Manage Quizzes')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="mb-1">Quizzes</h3>
            <p class="text-muted mb-0">
                Create and manage course assessments.
            </p>
        </div>

        <a href="{{ route('admin.quizzes.create') }}"
            class="btn btn-primary">
            <i class="fa-solid fa-plus me-2"></i>
            Add Quiz
        </a>
    </div>


    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        {{ session('success') }}
        <button type="button"
            class="btn-close"
            data-bs-dismiss="alert">
        </button>
    </div>
    @endif


    <div class="card shadow-sm border-0">
        <div class="card-body p-0">

            <div class="table-responsive">
                <table class="table table-hover mb-0">

                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Quiz Title</th>
                            <th>Course</th>
                            <th>Pass %</th>
                            <th>Status</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($quizzes as $quiz)
                        <tr>
                            <td>{{ $quizzes->firstItem() + $loop->index }}</td>

                            <td>
                                <strong>{{ $quiz->title }}</strong>
                            </td>

                            <td>
                                {{ $quiz->course?->title ?? 'N/A' }}
                            </td>

                            <td>{{ $quiz->pass_percentage }}%</td>

                            <td>
                                @if($quiz->status === 'active')
                                <span class="badge bg-success">Active</span>
                                @else
                                <span class="badge bg-secondary">Inactive</span>
                                @endif
                            </td>

                            <td class="text-end">
                                <a href="{{ route('admin.quiz.questions.index', $quiz->id) }}"
                                    class="btn btn-sm btn-primary"
                                    title="Manage Questions">
                                    <i class="fa-solid fa-list-check"></i>
                                </a>
                                
                                <a href="{{ route('admin.quizzes.edit', $quiz->id) }}"
                                    class="btn btn-sm btn-warning">
                                    <i class="fa-solid fa-pen"></i>
                                </a>

                                <form action="{{ route('admin.quizzes.destroy', $quiz->id) }}"
                                    method="POST"
                                    class="d-inline"
                                    onsubmit="return confirm('Are you sure you want to delete this quiz?')">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                        class="btn btn-sm btn-danger">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>

                                </form>

                            </td>
                        </tr>

                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">
                                No quizzes have been created yet.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>

        </div>
    </div>

    <div class="mt-3">
        {{ $quizzes->links() }}
    </div>

</div>

@endsection