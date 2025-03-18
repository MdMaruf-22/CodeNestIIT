@extends('layouts.dashboard')

@section('title', $problem->title)

@section('content')

<h2 class="text-2xl font-bold text-gray-900 mt-6">{{ $problem->title }}</h2>
<p class="text-gray-700">{{ $problem->description }}</p>

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
    document.addEventListener("DOMContentLoaded", function () {
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
                <td class="border p-2"><pre>{{ Str::limit($submission->code, 50) }}</pre></td>
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

<script>
    document.addEventListener("DOMContentLoaded", function () {
        @if (session('status'))
            showPopup("{{ session('status') }}", "{{ session('output') }}");
        @endif
    });

    function showPopup(status, output) {
        let popupTitle = document.getElementById("popupTitle");
        let popupMessage = document.getElementById("popupMessage");
        let popup = document.getElementById("submissionPopup");

        if (status === "Correct") {
            popupTitle.textContent = "✅ Code Accepted!";
            popupMessage.textContent = "Your code has passed all test cases.";
        } else {
            popupTitle.textContent = "❌ Code Rejected!";
            popupMessage.textContent = "Your output: " + output + "\n\nExpected output did not match.";
        }

        popup.classList.remove("hidden");
    }

    function closePopup() {
        document.getElementById("submissionPopup").classList.add("hidden");
    }
</script>

@endsection
