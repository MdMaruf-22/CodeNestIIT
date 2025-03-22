@extends('layouts.dashboard')

@section('title', $problem->title)

@section('content')

<div class="flex flex-col md:flex-row justify-between mt-6">
    <div class="md:w-3/4">
        <h2 class="text-2xl font-bold text-gray-900">{{ $problem->title }}</h2>
        <p class="text-gray-700">{{ $problem->description }}</p>
    </div>

    <!-- Difficulty and Tags Section -->
    <div class="md:w-1/4 bg-gray-50 p-4 rounded-lg shadow-md">
        <h3 class="font-semibold text-gray-800">Difficulty:</h3>
        <p class="bg-gray-100 p-2 rounded text-center font-semibold text-sm text-gray-900">{{ $problem->difficulty }}</p>

        <h3 class="font-semibold mt-4 text-gray-800">Tags:</h3>
        <div class="flex flex-wrap gap-2 mt-2">
            @foreach ($problem->tags_array as $tag)
            <span class="px-3 py-1 bg-blue-200 text-blue-900 text-xs font-semibold rounded-full">{{ trim($tag) }}</span>
            @endforeach
        </div>

        <!-- Hint Section -->
        @if($problem->hint)
        <h3 class="font-semibold mt-4 text-gray-800">Hint:</h3>
        <p class="bg-yellow-100 p-2 rounded">{{ $problem->hint }}</p>
        @endif

        <!-- Editorial Section -->
        @if($problem->editorial)
        <h3 class="font-semibold mt-4 text-gray-800">Editorial:</h3>
        <p class="bg-green-100 p-2 rounded hidden" id="editorial">{{ $problem->editorial }}</p>
        <button onclick="document.getElementById('editorial').classList.toggle('hidden')" class="mt-2 px-4 py-2 bg-green-500 text-white rounded">
            Toggle Editorial
        </button>
        @endif
    </div>

</div>

<h3 class="font-semibold mt-4">Input Format:</h3>
<p class="bg-gray-100 p-2 rounded">{{ $problem->input_format }}</p>

<h3 class="font-semibold mt-4">Output Format:</h3>
<p class="bg-gray-100 p-2 rounded">{{ $problem->output_format }}</p>

<h3 class="font-semibold mt-4">Sample Input:</h3>
<pre class="bg-gray-200 p-2 rounded">{{ $problem->sample_input }}</pre>

<h3 class="font-semibold mt-4">Sample Output:</h3>
<pre class="bg-gray-200 p-2 rounded">{{ $problem->sample_output }}</pre>

<!-- Code Editor -->
<h3 class="font-semibold mt-6">Write Your Code:</h3>
<div class="border rounded bg-gray-900 text-white p-2">
    <div id="editor" style="height: 300px; width: 100%;">#include&lt;stdio.h&gt;

        int main() {
        printf("Hello, World!");
        return 0;
        }
    </div>
</div>

<!-- Hidden Input Field for Submission -->
<form action="{{ route('problems.submit', $problem->id) }}" method="POST" class="mt-4">
    @csrf
    <input type="hidden" name="code" id="code">
    <button type="submit" class="mt-4 px-6 py-3 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition duration-300">Submit Code</button>
</form>

<!-- Load ACE Editor -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.4.12/ace.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        console.log("Script Loaded Successfully!");

        var editor = ace.edit("editor");
        editor.setTheme("ace/theme/dracula");
        editor.session.setMode("ace/mode/c_cpp");

        // Automatically update the hidden input whenever code changes
        editor.getSession().on('change', function() {
            document.getElementById("code").value = editor.getValue();
        });

        // Ensure code is stored before form submission
        document.querySelector("form").addEventListener("submit", function(event) {
            let code = editor.getValue().trim();
            if (code === "") {
                alert("Please enter some code before submitting.");
                event.preventDefault();
                return;
            }

            document.getElementById("code").value = code; // Update before submitting
            console.log("Captured Code Before Submission:", code);
        });
    });
</script>

<!-- Test with Custom Input -->
<h3 class="font-semibold mt-6">Test with Custom Input:</h3>
<textarea id="customInput" rows="3" class="w-full p-2 border rounded" placeholder="Enter custom input..."></textarea>

<button onclick="runCustomTest()" class="mt-2 px-4 py-2 bg-blue-500 text-white rounded">
    Run with Custom Input
</button>

<div id="loadingSpinner" class="hidden text-blue-600 mt-2">
    <svg class="animate-spin h-5 w-5 mx-auto text-blue-500" viewBox="0 0 24 24">
        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
    </svg>
    <p class="text-center text-sm">Running test...</p>
</div>
<!-- Custom Output Display -->
<div id="customOutputBox" class="hidden mt-4 p-3 bg-gray-100 rounded">
    <h3 class="font-semibold">Output:</h3>
    <pre id="customOutput" class="text-gray-800"></pre>
</div>



<h3 class="font-semibold mt-6">Submission History</h3>
<table class="w-full mt-4 border-collapse border border-gray-300">
    <thead>
        <tr class="bg-gray-200">
            <th class="border p-2">Submitted Code</th>
            <th class="border p-2">Output</th>
            <th class="border p-2">Status</th>
            <th class="border p-2">Time</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($problem->submissions->where('user_id', auth()->id()) as $submission)
        <tr class="border">
            <td class="border p-2">
                <pre>{{ Str::limit($submission->code, 50) }}</pre>
            </td>
            <td class="border p-2">{{ $submission->output }}</td>
            <td class="border p-2 {{ $submission->status === 'Correct' ? 'text-green-600' : 'text-red-600' }}">
                {{ $submission->status }}
            </td>
            <td class="border p-2">{{ $submission->created_at->diffForHumans() }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<!-- Submission Result Popup -->
<div id="submissionPopup" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
    <div class="bg-white p-6 rounded-lg shadow-lg text-center max-w-md">
        <h2 id="popupTitle" class="text-2xl font-bold"></h2>
        <p id="popupMessage" class="mt-2"></p>
        <button onclick="closePopup()" class="mt-4 px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">OK</button>
    </div>
</div>

<!-- Discussion and Comment -->
<h3 class="font-semibold mt-6">Discussion & Comments</h3>

@if(auth()->check())
<form action="{{ route('comments.store', $problem->id) }}" method="POST" class="mt-4">
    @csrf
    <textarea name="content" rows="3" class="w-full p-2 border rounded" placeholder="Write a comment..."></textarea>
    <button type="submit" class="mt-2 px-4 py-2 bg-green-500 text-white rounded">Post Comment</button>
</form>
@else
<p class="text-gray-600 mt-2">You must be logged in to comment.</p>
@endif

<ul class="mt-4">
    @foreach ($problem->comments->where('parent_id', null) as $comment)
    <li class="border-b p-2">
        <p class="font-semibold">{{ $comment->user->name }}</p>
        <p>{{ $comment->content }}</p>
        <p class="text-sm text-gray-500">{{ $comment->created_at->diffForHumans() }}</p>

        <!-- Show Replies -->
        <ul class="mt-2 ml-6">
            @foreach ($comment->replies as $reply)
            <li class="border-l-2 pl-2">
                <p class="font-semibold">{{ $reply->user->name }}</p>
                <p>{{ $reply->content }}</p>
                <p class="text-sm text-gray-500">{{ $reply->created_at->diffForHumans() }}</p>
            </li>
            @endforeach

            <!-- Reply Button (After Last Reply) -->
            @if(auth()->check())
            <li class="mt-2">
                <form action="{{ route('comments.store', $problem->id) }}" method="POST">
                    @csrf
                    <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                    <textarea name="content" rows="2" class="w-full p-2 border rounded" placeholder="Reply to this comment..."></textarea>
                    <button type="submit" class="mt-1 px-3 py-1 bg-blue-500 text-white rounded">Reply</button>
                </form>
            </li>
            @endif
        </ul>
    </li>
    @endforeach
</ul>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        @if(session('status') === 'Correct')
        showSuccessPopup();
        @elseif(session('status') === 'Incorrect')
        showFailedTestCase(`{{ session('failed_input') }}`, `{{ session('expected_output') }}`, `{{ session('actual_output') }}`);
        @endif
    });

    function showSuccessPopup() {
        let popupTitle = document.getElementById("popupTitle");
        let popupMessage = document.getElementById("popupMessage");
        let popup = document.getElementById("submissionPopup");

        popupTitle.textContent = "✅ Code Accepted!";
        popupMessage.innerHTML = "<p>🎉 Congratulations! Your code has passed all test cases.</p>";

        popup.classList.remove("hidden");
    }

    function showFailedTestCase(input, expected, actual) {
        let popupTitle = document.getElementById("popupTitle");
        let popupMessage = document.getElementById("popupMessage");
        let popup = document.getElementById("submissionPopup");

        popupTitle.textContent = "❌ Code Rejected!";
        popupMessage.innerHTML = `
            <p><strong>Failed Test Case:</strong></p>
            <p><strong>🔹 Input:</strong> <code>${input.replace(/\n/g, "<br>")}</code></p>
            <p><strong>✅ Expected Output:</strong> <code>${expected.replace(/\n/g, "<br>")}</code></p>
            <p><strong>❌ Your Output:</strong> <code>${actual.replace(/\n/g, "<br>")}</code></p>
        `;

        popup.classList.remove("hidden");
    }

    function closePopup() {
        document.getElementById("submissionPopup").classList.add("hidden");
    }

    function runCustomTest() {
        let editor = ace.edit("editor");
        let code = editor.getValue().trim();
        let customInput = document.getElementById("customInput").value.trim();
        let outputBox = document.getElementById("customOutputBox");
        let outputField = document.getElementById("customOutput");
        let spinner = document.getElementById("loadingSpinner");

        if (!code) {
            alert("Please enter some code before testing.");
            return;
        }

        // Show loading spinner and output box
        outputBox.classList.remove("hidden");
        spinner.classList.remove("hidden");
        outputField.textContent = "";

        let startTime = Date.now();

        fetch("{{ route('problems.runCustom', $problem->id) }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({
                    code: code,
                    input: customInput
                })
            })
            .then(response => response.json())
            .then(data => {
                let elapsedTime = (Date.now() - startTime) / 1000;
                spinner.classList.add("hidden"); // Hide spinner
                outputField.innerHTML = `Output (Executed in ${elapsedTime.toFixed(2)}s):\n${data.output}`;
            })
            .catch(error => {
                spinner.classList.add("hidden");
                outputField.textContent = "❌ Error: " + error.message;
            });
    }
</script>

@endsection