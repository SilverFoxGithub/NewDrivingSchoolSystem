<?php
$data = json_decode(file_get_contents("php://input"), true);
$message = strtolower($data['message']);

$responses = [
    "what is a theoretical driving course?" => "A theoretical driving course covers road rules, traffic signs, and safe driving practices.",
    "how many lessons are needed for a practical course?" => "Typically, practical lessons range from 10 to 20 sessions, depending on your skill level.",
    "what is defensive driving?" => "Defensive driving is a practice where drivers anticipate and respond to potential hazards on the road to prevent accidents.",
    "how can i pass my driving test?" => "Practice regularly, understand traffic rules, and stay calm during the test. Review your feedback to improve weaknesses!",
    "what are common driving mistakes?" => "Common mistakes include speeding, not checking blind spots, and misjudging distances. Practice and feedback help fix these!",
    "what is a theoretical driving course?" => "A theoretical driving course covers traffic laws, road safety, and driving ethics.",
    "how do i schedule a class?" => "Log in to your account, navigate to 'Schedule', and choose a time slot that works for you.",
    "how can i track my progress?" => "Go to the 'Progress' section on your dashboard to view your course completion percentage and feedback from instructors."
];

$response = $responses[$message] ?? "I'm not sure about that. Try asking another question or ask your instructor!";
echo $response;
?>