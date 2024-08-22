<?php
function getEvents() {
    $eventDir = 'images/events/';
    $events = array();

    // Scan the directory for subfolders
    if ($handle = opendir($eventDir)) {
        while (false !== ($entry = readdir($handle))) {
            if ($entry != "." && $entry != ".." && is_dir($eventDir . $entry)) {
                // Extract the date part of the folder name (assumes "Month Year Event Name" format)
                $datePart = preg_replace('/[^a-zA-Z0-9 ]/', '', $entry);
                $dateParts = explode(' ', $datePart);
                $dateString = implode(' ', array_slice($dateParts, 0, 2));

                // Convert to a timestamp
                $timestamp = strtotime($dateString);
                if ($timestamp !== false) {
                    // Store the full folder name with the timestamp as the key for sorting
                    $events[$timestamp] = $entry;
                }
            }
        }
        closedir($handle);
    }

    // Sort events by date (most recent first)
    krsort($events);

    return $events;
}

$events = getEvents();
?>

<section id="photos">
    <h2>Event Highlights</h2>
    <?php foreach ($events as $date => $folder): ?>
        <div class="event-folder">
            <h3><?php echo htmlspecialchars($folder); ?></h3>
            <?php
            $photos = glob("images/events/$folder/*.{jpg,jpeg,png,gif}", GLOB_BRACE);
            foreach ($photos as $photo): ?>
                <div class="photo">
                    <img src="<?php echo htmlspecialchars($photo); ?>" alt="Event Photo">
                </div>
            <?php endforeach; ?>
        </div>
    <?php endforeach; ?>
</section>
