// var sessionTimeoutMinutes = 0.1; // Session timeout duration in minutes
// var sessionTimeoutMilliseconds = sessionTimeoutMinutes * 60 * 1000; // Convert to milliseconds
var sessionTimeoutMilliseconds = 60 * 1000; // Convert to milliseconds

var timeoutTimer;

function logout() {
  // Perform logout action
  window.location.href = 'index.php'; // Replace with your logout page or action
// console.log("logged out")
}

function resetTimeout() {
  clearTimeout(timeoutTimer);
  timeoutTimer = setTimeout(logout, sessionTimeoutMilliseconds);
}


// Attach event listeners to relevant user interactions
window.addEventListener('mousemove', resetTimeout);
window.addEventListener('keypress', resetTimeout);
window.addEventListener('click', resetTimeout);

// Start the initial timeout
resetTimeout();