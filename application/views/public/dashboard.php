<div class="ks-page-container">
    <div class="ks-column ks-page"> 
        <div class="search-sec">
            <div class="container">
                <div class="row">
                    <?php echo $this->session->flashdata('success'); ?>
                    <div class="ser-sec">
                        <p class="src-hdg">SEARCH PROJECT</p>
                        <input type="text" class="search-text" placeholder="Type Project Name Here..." ><i style="display: none;"class="cursue-point clear-search la la-times"></i><button><i class="fa fa-search search" aria-hidden="true"></i></button>
                        <ul class="search-list-dropdown auto-list">

                        </ul>
                    </div>

                </div>

            </div>
        </div>
        <div class="main-cnt-sec">
            <div class="container">
                <div class="row">
                    <div class="prj-hdng">
                        <p>MY Projects</p>
                    </div>
                    <!--div class="prj-flt">
                        <select>
                            <option>Filter Box</option>
                            <option>choose......</option>
                        </select>
                        <select>
                            <option>Filter Box</option>
                            <option>choose......</option>
                        </select>
                    </div-->
                    <div class="prjt-cnt-main-sec project-list-section">

                    </div>

                    <!--div class="pagination-section">
                        <div class="col-xl-12 text-center">
                            <div class="ks-text-block">
                                <button class="btn btn-success load-more" page="0">Load More</button>
                            </div>

                        </div>
                    </div-->

                </div>
            </div>
        </div>
    </div>
</div>

<div style="display: none;" id="ks-izi-modal-success"
     class="ks-izi-modal"
     data-iziModal-fullscreen="true"
     data-iziModal-title='Welcome to "UpKepr"'
     data-iziModal-subtitle=" Web toolkit to manage all of your projects at once place."
     data-iziModal-icon="la la-home"
     data-iziModal-padding="20"
     data-iziModal-autoopen="false"
     data-iziModal-headercolor="#3c4b5a">

    <p>
        <span>ADD YOUR FIRST PROJECT </span></br>
        know how it works 
    </p>
    <p>
        <span> CONFIGURE & BRAND YOUR REPORTS</span></br>
        know how it works 
    </p>
    <p>
        To know more about the working of the application, please visit the knowledgebase page. 
    </p>
</div>

<script>
    $(document).ready(function () {
        $('.clear-search').click(function () {
            $('.search-text').val('');
            $('.auto-list').html('');
            $(this).css('display', 'none');
            $('.search-text').focus();
        });
    });

</script>
<script src="<?= site_url('assets/public/js/dashboard.js'); ?>"></script>
