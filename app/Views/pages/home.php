<?= $this->extend('layouts/default') ?>

<?= $this->section('content') ?>

<div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="<?= base_url('assets/images/dice_crop.jpg') ?>" class="d-block w-100" alt="...">
    </div>
    <div class="carousel-item">
      <img src="<?= base_url('assets/images/card_crop.jpg') ?>" class="d-block w-100" alt="...">
    </div>
    <div class="carousel-item">
      <img src="<?= base_url('assets/images/card_slot.jpg') ?>" class="d-block w-100" alt="...">
    </div>
    <div class="carousel-item">
      <img src="<?= base_url('assets/images/chips_crop.jpg') ?>" class="d-block w-100" alt="...">
    </div>
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div>
<div class="container">
  <div class="row mt-4">
    <?php
    if (!empty($gameList)) {
      foreach ($gameList as $game) {
    ?>
        <div class="col">
          <div class="card card-cover h-100 overflow-hidden text-bg-dark rounded-4 shadow-lg" style="background-image: url('<?= base_url('uploads/banners' . $game['banner_image']) ?>')">
            <div class="d-flex flex-column h-100 p-5 pb-3 text-dark text-shadow-1">
              <h3 class="pt-5 mt-5 mb-4 display-6 lh-1 fw-bold"><?= $game['title'] ?></h3>
              <ul class="d-flex list-unstyled mt-auto">
                <li class="me-auto">
                  <a href="<?=base_url('details/'.$game['id'])?>" class="btn btn-sm btn-outline-warning stretched-link">
                    <i class="bi bi-eye-fill"></i>
                  </a>
                </li>
                <li class="d-flex align-items-center me-3">
                  <i class="bi bi-calendar-date"></i>&nbsp;
                  <small title="Date"><?= date('d-m-Y', strtotime($game['result_date'])) ?></small>
                </li>
                <li class="d-flex align-items-center">
                  <i class="bi bi-alarm"></i>&nbsp;
                  <small title="Time"><?= date('g:i a', strtotime($game['result_date'])) ?></small>
                </li>
              </ul>
            </div>
          </div>
        </div>
      <?php
      }
    } else {
      ?>
      <div class="row mt-4">        
        <?php
        $itemList = [1,2,3];
        foreach($itemList as $item){
        ?>
        <div class="col">
          <div class="card card-cover h-100 overflow-hidden text-bg-dark rounded-4 shadow-lg" style="background-image: url('<?= base_url('assets/images/card/event_'.$item.'.jpg') ?>')">
            <div class="d-flex flex-column h-100 p-5 pb-3 text-dark text-shadow-1">
              <h3 class="pt-5 mt-5 mb-4 display-6 lh-1 fw-bold">Coming Soon</h3>
              <ul class="d-flex list-unstyled mt-auto">
                <li class="me-auto">
                  <a href="#" class="btn btn-sm btn-outline-warning stretched-link">
                    <i class="bi bi-eye-fill"></i>
                  </a>
                </li>
                <li class="d-flex align-items-center me-3">
                  <i class="bi bi-calendar-date"></i>&nbsp;
                  <small title="Date"> --/--/---- </small>
                </li>
                <li class="d-flex align-items-center">
                  <i class="bi bi-alarm"></i>&nbsp;
                  <small title="Time"> -:- - </small>
                </li>
              </ul>
            </div>
          </div>
        </div>
        <?php
        }
        ?>
      </div>
    <?php
    }
    ?>
    <div class="d-flex flex-row-reverse">
      <div class="p-2">
        <a href="<?=base_url('view-more')?>" class="btn btn-primary rounded">View More...</a>
      </div>
    </div>
  </div>
</div>

<?= $this->endSection() ?>