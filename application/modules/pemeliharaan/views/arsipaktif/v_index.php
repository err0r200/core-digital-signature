<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<div class="card card-outline-primary">
    <div class="card-header">
		<h4 class="card-title"><strong><?= $template['title']; ?></strong></h4>
        <div class="card-header-actions" id="actionButton">
            <div class="btn-toolbar">
            <?php if($roleAdd){ ?>
                <a id="add-btn" class="btn btn-label btn-bold btn-primary btn-custom">
                    Tambah
                    <label><i class="ti-plus"></i></label>
                </a>
            <?php } ?>
            </div>
        </div>
        
	</div>
    <div class="card-body" id="tbl-container">
        <form class="" method="POST" action="" id="frmFilter">
         <div class="row">
            <div class="col-md-2">  
               <div class="form-group">
                  <label>Klasifikasi :</label>
                   <select name="f_klasifikasi" id="f_klasifikasi" class="form-control" data-provide="selectpicker" data-live-search="true">
                    <option value="">-- Filter Klasifikasi --</option>
                    <?php
                        foreach($KlasifikasiList as $k => $kl):
                    ?>
                        <option value="<?= encode($kl->klasId); ?>"><?= $kl->klasifikasi ?></option>
                    <?php endforeach; ?>
                    </select>
               </div>
               
            </div>
            <!-- <div class="col-md-2">  
                <div class="form-group">
                  <label>Berkas :</label>
                   <select name="f_berkas" id="f_berkas" class="form-control" data-provide="selectpicker" data-live-search="true">
                    <option value="">-- Filter Berkas --</option>
                    <?php
                        foreach($GetAllBerkas as $b => $bk):
                    ?>
                        <option value="<?= encode($bk->brksId); ?>"><?= $bk->nama_berkas ?></option>
                    <?php endforeach; ?>
                    </select>
               </div>
               
            </div> -->
            <div class="col-md-2">  
               <div class="form-group pt-30">
                   <button type="submit" class="btn btn-label btn-bold btn-primary"> Filter <label><i class="ti-search"></i></label></button>
               </div>
            </div> 
         </div>
        </form> 

        <div class="row">
	  		<div class="col-md-3"></div>
	  		<div class="col-md-2"></div>
	  		<div class="col-md-2"></div>

			<div class="col-md-2">
				<select name="f_aksi" id="f_aksi" class="form-control bulk-action-selection" data-provide="selectpicker" data-live-search="true">
						<option value="">-Pilihan Aksi -</option>
						<option value="delete_all">Hapus</option>
					
				</select>
			</div>
			<div class="col-md-2">  
               <div class="form-group ">
                   <button type="submit" class="btn btn-label btn-bold btn-info table-group-action-submit" onclick="bulkAction()"> Submit <label><i class="ti-check"></i></label></button>
               </div>
            </div>
        </div>

        <table class="table table-separated table-striped" id="datatables_ajax" data-scroll-y="auto" data-scroll-collapse="true" >
            <thead class="bg-color-primary1">
            <tr role="row" class="heading">
                <th width="1%" class="text-center">
                    <div class="custom-controls-stacked">
                        <label class="custom-control custom-checkbox">
                            <input type="checkbox" name="select_all" class="custom-control-input select-all" onchange="selectAll()" >
                            <span class="custom-control-indicator"></span>
                        </label>
                    </div>
                </th>
                <th width="2%">Nomor Berkas</th>
                <th width="3%">Klasifikasi</th>
                <th width="5%">Nama Berkas</th>
                <th width="2%">Jumlah Arsip</th>
                <th width="3%">Aksi</th>
            </tr>
            </thead>
        </table>


    </div>
</div>
<!-- Tambah Modal -->
<div class="modal fade" id="modal_form"  tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Pilih Daftar Kegiatan</h4>
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body form-type-round">
            <?php echo form_open($moduleAdd,  'class="form-horizontal" id="form" role="form"'); ?>
                <div class="card card-bordered card-body">
                    <div class="row">
                        <div class="form-group col-lg-6">
                            <label class="text-dark required"> Klasifikasi</label>
                            <select name="brksKlasifikasiId" id="brksKlasifikasiId" class="form-control"  data-provide="selectpicker">
                                <option value="">-- Pilih Klasifikasi --</option>
                                <?php
                                    foreach($KlasifikasiList as $k => $kl):
                                ?>
                                <option value="<?= encode($kl->klasId); ?>"><?= $kl->klasifikasi ?></option>
                                <?php endforeach; ?>
                            </select>
                            <span class="invalid-feedback" id="error_brksKlasifikasiId"></span>
                        </div>
                        
                        <div class="form-group col-lg-6">
                            <label class="text-dark require">Nomor Berkas</label>
                            <input class="form-control" type="text" id="brksNomor" name="brksNomor" >
                            <small class="form-text text-warning">Nomor Berkas Akan Muncul Ketika Memilih Klasifikasi</small>
                            <span class="invalid-feedback" id="error_brksNomor"></span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-lg-12">
                            <label class="text-dark require">Nama Berkas</label>
                            <input class="form-control" type="text" name="brksNama" id="brksNama">
                            <span class="invalid-feedback" id="error_brksNama"></span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-lg-12">
                            <label class="text-dark">Keterangan Berkas</label>
                            <textarea class="form-control" rows="5" name="brksKeterangan" id="brksKeterangan"></textarea>
                            <span class="invalid-feedback" id="error_brksKeterangan"></span>
                        </div>
                    </div>
                </div>
                <footer class="mx-4 my-4 text-right">
                    <button class="btn btn-round btn-custom" type="submit" >Simpan</button>
                </footer>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>
<!-- modal -->




<script>
    $(function() {
        // Picker
        $('#refresh-picker, #refresh-prodi').on('click', function(e) { $('.select-parent').val('default').selectpicker('refresh');   });

        $("#brksKlasifikasiId").change(function(){
            var id = $(this).val();
            $.ajax({
                type: "GET",
                url: "<?= site_url($module.'/ajax/select');?>",
                data: {data:id, type : 'select_nomor_klasifikasi'},
                // dataType: "json",
                success: function (res) {
                    var json = $.parseJSON(res);
                    $("#brksNomor").val(json.data);
                }
            });
        });
       
       
    });
</script>

<!-- Javascript -->
<script type="text/javascript">
$(function() {

var ajaxParams = {};
var setAjaxParams = function(name, value) {
    ajaxParams[name] = value;
};

var dt = $('#datatables_ajax').DataTable({
  "processing": true,
  "serverSide": true,
  "ajax" : {
     "url" : "<?php echo site_url( $module . '/ajax/datatables');?>",
     "type" : "POST",
     "data" : function(d) {
            $.each(ajaxParams, function(key, value) {
            d[key] = value;
            });
    }
  },
  'drawCallback': function( settings ) {
     $('[data-provide="tooltip"]').tooltip();
  },
  //"dom": "<'row'<'col-md-4 col-sm-12'l<'table-group-actions pull-right'>>r><'table-scrollable't><'row'<'col-md-8 col-sm-12'i><'col-md-4 col-sm-12'p>>",
  'language' : {
     'search': 'Cari',
     'searchPlaceholder':'Masukan Kata Kunci....',
     'lengthMenu': "Tampil _MENU_",
     'info': "_START_ - _END_ dari _TOTAL_",
     "paginate": {
        "previous": "Prev",
        "next": "Next",
        "last": "Last",
        "first": "First",
        "page": "Page",
        "pageOf": "of"
     }
  },
  'order': [[ 2, 'desc' ]],
  'columnDefs': [
    //  {"visible": false, "targets":[0]},
     {"orderable": false, "searchable": false, "targets": [0,4,5]},
     {"className":"text-center", "targets": [0,4,5]}
  ]
});

dt.on( 'order.dt search.dt', function () {
    dt.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
        // cell.innerHTML = i+1;
    });
}).draw();



$('#add-btn').on('click', function(e) {
    e.preventDefault();
    $('#form')[0].reset();
    $('#form').find('input').removeClass('is-invalid');
    $('#form').find('.invalid-feedback').empty();

    $('.modal-title').text('Tambah Data');
    $('#modal_form').modal('show');
    dt.ajax.reload(null, false);
});

$('#form').on('submit', function(e) {
        e.preventDefault();

        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(result) {
                if (result.error == 'null') {
                $('#modal_form').modal('hide');
                // notif({type:'success', message:result.msg});
                // app.toast(result.text);
                Swal.fire({
                    title: "Informasi",
                    text: result.text,
                    icon: result.type
                });
                dt.ajax.reload(null, false);
                
                } else {
                $.each(result.error, function(i, log) {
                    if(log != ''){
                        $('[name="'+i+'"]').addClass('is-invalid');
                    }

                    $('#error_'+i).text(log);
                });
                }            
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(textStatus + errorThrown);
            }
        });
    });

    // ----------------- Modal -----------------//

    // ----------------- Setting Jenis -----------------//
    var modalSetting = function(opt) {
        opt = opt || {};
        app.modaler({
            title: 'Setting Kolom Jenis',
            url: opt.url,
            footerVisible: false,
            size:"lg",
            bodyExtraClass:"form-type-round",
            onConfirm: opt.callback
        });
    }

    $('#datatables_ajax').on('click', '#set-btn', function() {
        var id = $(this).attr('data-id'),
        module = "<?php echo site_url($module.'/set_kolom/') ?>" + id;
        modalSetting({
            url: module,
            callback: function(modal) {
                $frm = modal.find('form');
                $($frm[0]).on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: $(this).serialize(),
                    dataType: 'json',
                    success: function(result) {

                        if (result.error == 'null') {
                            $('#'+modal[0].id).modal('hide');
                            Swal.fire({
                                title: "Informasi",
                                text: result.text,
                                icon: result.type
                            });
                            dt.ajax.reload(null, false);
                        } else {
                            $.each(result.error, function(i, log) {
                                if(log != ''){
                                    $('[name="'+i+'"]').addClass('is-invalid');
                                }

                                $('.error_'+i).text(log);
                            
                            });
                            
                            Swal.fire({
                                    title: "Informasi",
                                    text: "Periksa Semua Form Inputan",
                                    icon: "warning"
                                });
                           
                        }            
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(textStatus + errorThrown);
                    }
                });
                });
            }
        });
    });


    // ----------------- Edit -----------------//

    var modalEdit = function(opt) {
        opt = opt || {};
        app.modaler({
            title: 'Ubah Data',
            url: opt.url,
            footerVisible: false,
            size:"lg",
            bodyExtraClass:"form-type-round",
            onConfirm: opt.callback
        });
    }

    $('#datatables_ajax').on('click', '#edit-btn', function() {
        var id = $(this).attr('data-id'),
        module = "<?php echo site_url($module.'/update/') ?>" + id;
        modalEdit({
            url: module,
            callback: function(modal) {
                $frm = modal.find('form');
                $($frm[0]).on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: $(this).serialize(),
                    dataType: 'json',
                    success: function(result) {

                        if (result.error == 'null') {
                            $('#'+modal[0].id).modal('hide');
                            Swal.fire({
                                title: "Informasi",
                                text: result.text,
                                icon: result.type
                            });
                            dt.ajax.reload(null, false);
                        } else {
                            $.each(result.error, function(i, log) {
                                if(log != ''){
                                    $('[name="'+i+'"]').addClass('is-invalid');
                                }

                                $('.error_'+i).text(log);
                            
                            });
                            
                            Swal.fire({
                                    title: "Informasi",
                                    text: "Periksa Semua Form Inputan",
                                    icon: "warning"
                                });
                           
                        }            
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(textStatus + errorThrown);
                    }
                });
                });
            }
        });
    });  


$('#datatables_ajax').on('click', '#delete', function(e) {
  e.preventDefault();
  var action = $(this).attr('href');

  app.modaler({
     html: 'Apakah Anda yakin ingin menghapus data ini?',
     title: 'Delete Method',
     cancelVisible: true,
     confirmText: 'YA',
     cancelText:'Tidak',
     cancelClass: 'btn btn-w-sm btn-secondary',
     confirmClass: 'btn btn-w-sm btn-danger',
     onConfirm: function() {
        $.get(action, function (result) {
           var status = (result.status == true) ? 'success' : 'danger';
           modalAlert({type:status, message:result.msg});
           dt.ajax.reload(null, false);
        }, "json");
     }
  });
});



$('#frmFilter').on('submit', function(e) {
    e.preventDefault();
    var _this = $(this);
    $('input, select', _this).each(function(){
        setAjaxParams($(this).attr('name'), $(this).val());
    });

    dt.ajax.reload(null, false);
});


 // ----------------- Modals -----------------//
 var modalAdd = function(opt) {
        opt = opt || {};
        app.modaler({
            title: 'Tambah Kolom',
            url: opt.url,
            footerVisible: false,
            size:'lg',
            onConfirm: opt.callback
        });
    }


    $('#s').on('click', '#add-btn', function() {
        moduleAdd = "<?php echo site_url($module . '/add');?>";

        modalAdd({
            url: moduleAdd,
            callback: function(modal) {
                $frm = modal.find('form');
                $($frm[0]).on('submit', function(e) {
                    e.preventDefault();
                    $.ajax({
                        url: $(this).attr('action'),
                        type: 'POST',
                        data: $(this).serialize(),
                        dataType: 'json',
                        success: function(result) {
                            if (result.error == 'null') {
                                $('#'+modal[0].id).modal('hide');
                            app.toast(result.text);
                                dt.ajax.reload(null, false);
                            } else {
                                $.each(result.error, function(i, log) {
                                $('[name="'+i+'"]').addClass('is-invalid');
                                $('#error_'+i).text(log);
                                });
                            }            
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            console.log(textStatus + errorThrown);
                        }
                    });
                });
            }
        });
    }); 

});




// Bulk Change

function bulkAction() {
    let action = $('#f_aksi').val();
    if (action === 'delete_all') {
        var selected_items = [];
        $('input[name^="data_id"]:checked').each(function() {
            selected_items.push($(this).val());
        });
        if (selected_items.length > 0) {
            Swal.fire({
                title: "<strong>Yakin Hapus Data</strong>",
                icon: "question",
                html: `
                Data Yang Sudah Di Hapus <em class="text-danger">tidak dapat dikembalikan</em>
                `,
                confirmButtonText: "Ya, saya yakin!",
                cancelButtonText: "Tidak",
                showCancelButton: true,
                focusConfirm: false,
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: '<?php echo site_url( $module . '/ajax/datatables');?>',
                        type: 'POST',
                        data: {data: selected_items,customActionType : 'group_action',customActionName : 'Delete'},
                        dataType: 'json',
                        success: function(result) {
                                $('#datatables_ajax').DataTable().ajax.reload();
                                // app.toast(result.customActionMessage);     
                                Swal.fire({
                                    title: "Informasi",
                                    text: result.customActionMessage,
                                    icon: result.customActionStatus
                                });
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            console.log(textStatus + errorThrown);
                            Swal.fire({
                                title: "Informasi",
                                text: result.customActionMessage,
                                icon: result.customActionStatus
                            });
                        }
                    });
                }
            });  
        } else {
            Swal.fire({
                title: "Error",
                text: 'Data yang anda pilih tidak ada',
                icon: 'error'
            });
        }
    } else {
        Swal.fire({
                title: "Error",
                text: 'Aksi yang dipilih tidak ada',
                icon: 'error'
            });
    }
}


function selectAll() {
    "use strict";
    if ($('.select-all').is(":checked")) {
        $(".data-id").prop("checked", true);
    } else {
        $(".data-id").prop("checked", false);
    }
}
</script>