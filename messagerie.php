<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: connexion.php');
    exit;
}

require 'bd_inscrire.php';

$user_id = $_SESSION['user_id'];

// Récupère l'ID du club
$stmt = $pdo->prepare("SELECT club_id FROM club_membres WHERE user_id = ?");
$stmt->execute([$user_id]);
$club_id = $stmt->fetchColumn();

if (!$club_id) {
    echo "Vous n'êtes pas encore membre d’un club.";
    exit;
}

// Récupère les messages
$stmt = $pdo->prepare("
    SELECT gm.*, u.nom, u.prenom, cm.role, c.nom_club 
    FROM message gm
    JOIN users u ON gm.user_id = u.id
    JOIN club_membres cm ON cm.user_id = u.id AND cm.club_id = gm.club_id
    JOIN clubs c ON c.id = gm.club_id
    WHERE gm.club_id = ?
    ORDER BY gm.created_at ASC
");


$stmt->execute([$club_id]);
$messages = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Chat du Club</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .chat-box {
            height: 500px;
            overflow-y: auto;
            border: 1px solid #ccc;
            border-radius: 10px;
            padding: 15px;
            background-color: #f8f9fa;
        }
        .message {
            margin-bottom: 15px;
        }
        .message .name {
            font-weight: bold;
        }
        .message .text {
            background-color: #e9ecef;
            padding: 10px;
            border-radius: 10px;
            display: inline-block;
            max-width: 80%;
        }
        .btn-custom {
        background-color:  #f76b21; /* Violet */
        color: white;
        border: none;
    }
    .btn-sm{
        background-color: #ffa873;
    }
    .btn-smm{
        background-color:  #f76b21; /* Violet */
        color: white;
        border: none;
    }
    .btn-smm:hover{
        background-color:  #f76b21;
    }
    .btn-cust{
         background-color: orange;
    }
    
    </style>
</head>
<body>
<div class="container py-4">
    <h3>💬 Chat </h3>

    <div class="chat-box mb-3" id="chatBox">
        <?php foreach ($messages as $msg): ?>
            <div class="message">
                <div class="name">
    <?= htmlspecialchars($msg['prenom']) ?> <?= htmlspecialchars($msg['nom']) ?>
    <span class="text-muted"> - <?= htmlspecialchars($msg['nom_club']) ?> (<?= htmlspecialchars($msg['role']) ?>)</span>
</div>

                <?php if (!empty($msg['message'])): ?>
                    <div class="text"><?= nl2br(htmlspecialchars($msg['message'])) ?></div>
                <?php endif; ?>
                <?php if (!empty($msg['audio_path'])): ?>
                    <audio controls src="<?= htmlspecialchars($msg['audio_path']) ?>"></audio>
                <?php endif; ?>
                <div class="text-muted small"><?= date('d/m/Y H:i', strtotime($msg['created_at'])) ?></div>
            </div>
            <?php if ($msg['user_id'] == $_SESSION['user_id']): ?>
    <div class="mt-1">
        <a href="modifier_message.php?id=<?= $msg['id'] ?>" class="btn btn-smm btn-primary">✏️ Modifier</a>
        <a href="supprimer_message.php?id=<?= $msg['id'] ?>" class="btn btn-sm " onclick="return confirm('Supprimer ce message ?')">🗑️ Supprimer</a>
    </div>
<?php endif; ?>

        <?php endforeach; ?>
    </div>

    <form action="envoyer_message.php" method="POST" enctype="multipart/form-data" class="d-flex flex-column gap-2">
        <textarea name="message" class="form-control" placeholder="Écrivez un message..."></textarea>
        <button type="submit" class="btn btn-custom">Envoyer</button>
    </form>

    <div class="mt-3">
        <button class="btn btn-cust" id="recordButton">🎙 Démarrer l'enregistrement</button>
        <button class="btn btn-secondary" id="stopButton" disabled>⏹ Arrêter</button>
        <form id="audioForm" action="envoyer_message.php" method="POST" enctype="multipart/form-data" style="display: none;">
            
            <input type="hidden" name="audio" id="audioData">
            <button type="submit" class="btn btn-success mt-2">Envoyer l'audio</button>
             <?php if ($msg['user_id'] == $_SESSION['user_id']): ?>
            <?php if (!empty($msg['audio_path'])): ?>
                <a href="supprimer_audio.php?id=<?= $msg['id'] ?>" class="btn btn-sm btn-danger mt-1"
                   onclick="return confirm('Supprimer ce message audio ?')">🗑️ Supprimer</a>
            <?php endif; ?>
            <?php endif; ?>
        </form>
    </div>
</div>

<script>
let mediaRecorder;
let audioChunks = [];

const recordBtn = document.getElementById('recordButton');
const stopBtn = document.getElementById('stopButton');
const audioForm = document.getElementById('audioForm');
const audioDataInput = document.getElementById('audioData');

recordBtn.onclick = async () => {
    const stream = await navigator.mediaDevices.getUserMedia({ audio: true });
    mediaRecorder = new MediaRecorder(stream);
    audioChunks = [];

    mediaRecorder.ondataavailable = e => {
        audioChunks.push(e.data);
    };

    mediaRecorder.onstop = () => {
        const audioBlob = new Blob(audioChunks, { type: 'audio/webm' });
        const file = new File([audioBlob], 'audio.webm');

        const formData = new FormData(audioForm);
        formData.append('audio_blob', file);

        fetch('envoyer_message.php', {
            method: 'POST',
            body: formData
        }).then(() => location.reload());
    };

    mediaRecorder.start();
    recordBtn.disabled = true;
    stopBtn.disabled = false;
};

stopBtn.onclick = () => {
    mediaRecorder.stop();
    recordBtn.disabled = false;
    stopBtn.disabled = true;
};
</script>
 <a href="dashboard.php" class="btn btn-secondary px-4">Retour au tableau de bord</a>
</body>
</html>
