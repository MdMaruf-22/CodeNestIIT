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
<!-- Check if the problem is already solved by the user -->
@php
    $solved = $contest->submissions()
        ->where('user_id', auth()->id())
        ->where('problem_id', $problem->id)
        ->where('status', 'Correct')
        ->exists();
@endphp

<!-- Show Problem Status -->
<h3 class="mt-4 font-semibold text-lg">
    Status: 
    @if ($solved)
        ✅ Solved
    @else
        ❌ Unsolved
    @endif
</h3>
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

<form action="{{ route('contests.submit', [$contest->id, $problem->id]) }}" method="POST">
    @csrf
    <input type="hidden" name="code" id="code">
    <button type="submit" class="mt-4 px-4 py-2 bg-green-500 text-white rounded">Submit Code</button>
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
        @if (session('status') === 'Correct')
            showSuccessPopup();
        @elseif (session('status') === 'Incorrect')
            showFailedTestCase(`{{ session('failed_input') }}`, `{{ session('expected_output') }}`, `{{ session('actual_output') }}`);
        @elseif (session('status') === 'Plagiarized')
            showPlagiarismPopup();
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
    function showPlagiarismPopup() {
        document.getElementById("popupTitle").innerText = "⚠️ Plagiarism Detected!";
        document.getElementById("popupMessage").innerText = 
            "Your submission is flagged for plagiarism. Please submit original code.";
        document.getElementById("submissionPopup").classList.remove("hidden");
    }
    function closePopup() {
        document.getElementById("submissionPopup").classList.add("hidden");
    }
</script>

@endsection