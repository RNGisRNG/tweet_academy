<div class="container follower">
    <button class="col-2" type="button" onclick="hidden_popup();">X</button>
    <?php foreach($followers as $follower){ ?>
        <div class="row">
            <img class="col-3" src="" alt="">
            <div class="col-5">
                <p><?= $_SESSION["userPseudo"] ?></p>
                <p><?= $_SESSION["userTagname"] ?></p>
            </div>
            <button class="col-2" type="button" onclick="unfollow or follow();"><? function php if follow or not ?></button>
        </div>
    <?php } ?>
</div>

<div class="container follower">
    <button class="col-2" type="button" onclick="hidden_popup();">X</button>
    <?php foreach($follows as $follow){ ?>
        <div class="row">
        <img class="col-3" src="" alt="">
        <div class="col-5">
            <p><?= $_SESSION["userPseudo"] ?></p>
            <p><?= $_SESSION["userTagname"] ?></p>
        </div>
        <button class="col-2" type="button" onclick="unfollow or follow();"><? function php if follow or not ?></button>
        </div>
    <?php } ?>
</div>