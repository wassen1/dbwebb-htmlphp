<?php
/**
 * Generate a flashmessage on one page load , based on information in the
 * session, then remove the information from the session.
 */
$message = $_SESSION["message"] ?? null;

// Clear the message, it should only be used once
$_SESSION["message"] = null;

// Return if no message
if (!$message) {
    return;
}



?><div class="flashmessage">
    <p><?= $message ?></p>
</div>
