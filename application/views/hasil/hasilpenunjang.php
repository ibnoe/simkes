		<script type="text/javascript">
					var bulanhasilpenunjang='';
                    var tahunhasilpenunjang='';
                    var tgl1hasilpenunjang='';
                    var tgl2hasilpenunjang='';
                    var penanggunghasilpenunjang='';
					var jns_tanggalhasilpenunjang='';

                function sethasilpenunjangjns_tanggal()
                {
                   jns_tanggalhasilpenunjang= $('#hasilpenunjangjenis').val();
                   $('#listhasilpenunjang').trigger('reloadGrid');
                }



                function sethasilpenunjangtanggal()
                {
                    if($('#hasilpenunjangtanggal1').val()=='')
                        {
                            alert('Isi dulu tanggal awalnya');
                        }
                    else
                    {
                    tgl1hasilpenunjang=$('#hasilpenunjangtanggal1').val();
                    tgl2hasilpenunjang=$('#hasilpenunjangtanggal2').val();
                    //alert(tgl1);alert(tgl2);
                    $('#listhasilpenunjang').trigger('reloadGrid');
                    }

                }

                function sethasilpenunjangbulan()
                {
                    //bulan= document.getElementById('hasilpenunjangbulan');
                    bulanhasilpenunjang = $('#hasilpenunjangbulan').val();
                    $('#listhasilpenunjang').trigger('reloadGrid');
                }

                function sethasilpenunjangtahun()
                {
                     tahunhasilpenunjang = $('#hasilpenunjangtahun').val();
                $('#listhasilpenunjang').trigger('reloadGrid');
                }



                $( "#hasilpenunjangtanggal1" ).datepicker({
                //dateFormat  : "dd MM yy",
                changeMonth: true,
                changeYear: true,
                showOn: "button",
                buttonImage : "<?php echo base_url();?>asset/images/calendar.gif",
                buttonImageOnly : true
                });

                $( "#hasilpenunjangtanggal2" ).datepicker({
                //dateFormat  : "dd MM yy",
                changeMonth     : true, // menampilkan dropdown untuk ganti bulan
                changeYear      : true, // menampilkan dropdown untuk ganti Tahun
                showOn          : "button",
                buttonImage     : "<?php echo base_url();?>asset/images/calendar.gif",
                buttonImageOnly : true
                });
		$(document).ready(function()
			{       $('#hasilpenunjangimpor').dialog({
                                        autoOpen:false,
                                        title:"Import Data Penunjang",
                                        resizable:false,
                                        width:350,
                                        height:150,
                                        show: 'drop',
                                        hide: 'scale',
                                        modal:true
                                        }
                                        );
                                $('#detailhasilpenunjang').dialog({
                                        autoOpen:false,
                                        title:"Detail",
                                        resizable:false,
                                        width:750,
                                        show: 'drop',
                                        hide: 'scale',
                                        modal:true
                                        }
                                        );
				var grid = $("#listhasilpenunjang");
				grid.jqGrid({
					url: '<?php echo base_url() ?>index.php/hasil/hasilpenunjang/json', //URL Tujuan Yg Mengenerate data Json nya
					datatype: "json", //Datatype yg di gunakan
					height: "auto", //Mengset Tinggi table jadi Auto menyesuaikan dengan isi table
					mtype: "GET",
                                        postData:{
                                        jns_tanggal : function()
                                        {

                                         return jns_tanggalhasilpenunjang;
                                        },bulan : function()
                                        {

                                         return bulanhasilpenunjang;
                                        },tahun : function()
                                        {

                                         return tahunhasilpenunjang;
                                        },tgl1 : function()
                                        {

                                         return tgl1hasilpenunjang;
                                        },tgl2 : function()
                                        {

                                         return tgl2hasilpenunjang;
                                        }

                                        },
					colNames: ['Id Transaksi','Tl Trans.','Tgl Kunjungan','Surat','No. Bukti','No Buku Besar','Restitusi','NIP','Penanggung','Pasien','Rujukan','Dokter','Laboratorium','Diagnosa'],
					colModel: [
						{name:'id_transaksi', key:true, index:'id_transaksi', hidden:true,editable:false,editrules:{required:true}},//name untuk variabel post yang dikirim saat menambah data
						{name:'nama_provider',index:'nama_provider',width:120,editable:true,editrules:{required:true}},//index untuk variabel yang digunakan saat pencarian
						{name:'almt_provider',index:'almt_provider',width:150,editable:true,editrules:{required:true}},
						{name:'langg_provider',index:'langg_provider', width:90, editable: true,edittype:"checkbox",editoptions: {value:"y:n"}},
						{name:'email_provider',index:'email_provider',width:150,align:'center',editable:true,editrules:{required:true}},
						{name:'fax_provider',index:'fax_provider',width:150,align:'center',editable:true,editrules:{required:true}},
						{name:'fax_provider',index:'fax_provider',width:150,align:'center',editable:true,editrules:{required:true}},
						{name:'fax_provider',index:'fax_provider',width:150,align:'center',editable:true,editrules:{required:true}},
						{name:'fax_provider',index:'fax_provider',width:150,align:'center',editable:true,editrules:{required:true}},
						{name:'fax_provider',index:'fax_provider',width:150,align:'center',editable:true,editrules:{required:true}},
						{name:'fax_provider',index:'fax_provider',width:150,align:'center',editable:true,editrules:{required:true}},
						{name:'fax_provider',index:'fax_provider',width:150,align:'center',editable:true,editrules:{required:true}},
						{name:'fax_provider',index:'fax_provider',width:150,align:'center',editable:true,editrules:{required:true}},
                                                {name:'tlp_provider',index:'tlp_provider',width:150,align:'center',editable:true,editrules:{required:true}}
					],
					rownumbers:true,
					rowNum: 10,
					rowList: [10,20,30],
					pager: '#pagerhasilpenunjang',
					sortname: 'id_transaksi',
                                        ondblClickRow: function(id_transaksi)
                                                    {

                                                    alert("You double click row with id: "+id_transaksi);
                                                    $('#detailhasilpenunjang').dialog('open');
                                                    $("#detailhasilpenunjang").load("<?php echo base_url() ?>index.php/hasil/hasilpenunjang/detail/"+id_transaksi);
                                                    
                                                    return false;
                                                    },
					viewrecords: true,
					sortorder: "desc",
					editurl: '<?php echo base_url() ?>index.php/hasil/hasilpenunjang/crud', //URL Proses CRUD Nya
					multiselect: false, 
					caption: "Data hasilpenunjang" //Caption List					
				});
				grid.jqGrid('navGrid','#pagerhasilpenunjang',{view:true,edit:false,add:false,del:true},{},{},{},{closeOnEscape:true,closeAfterSearch:false,multipleSearch:false, multipleGroup:false, showQuery:false,drag:true,showOnLoad:false,sopt:['cn'],resize:false,caption:'Cari Record', Find:'Cari', Reset:'Batalkan Pencarian'});
				jQuery("#listhasilpenunjang")
                                .jqGrid('navButtonAdd','#pagerhasilpenunjang',{caption:"Excel",buttonicon:"ui-icon-print",
                                onClickButton:function()
                                {   var sidx = grid.jqGrid('getGridParam','sortname');
                                    var sord = grid.jqGrid('getGridParam','sortorder');
                                    var page = grid.jqGrid('getGridParam','page');
                                    var row  = grid.jqGrid('getGridParam','rowNum');
                                    window.location.href="<?php echo base_url() ?>index.php/hasil/hasilpenunjang/ekspor?tgl2="+tgl2hasilpenunjang+"&tgl1="+tgl1hasilpenunjang+"&tahun="+tahunhasilpenunjang+"&bulan="+bulanhasilpenunjang+"&sidx="+sidx+"&page="+page+"&rows="+row+"&sord="+sord;

                                   //alert("BERHASIL ayo SEMANGAT kalahkan skripsi");
				}
				})
                                .jqGrid('navButtonAdd','#pagerhasilpenunjang',{caption:"Impor",buttonicon:"ui-icon-folder-open",
                                onClickButton:function()
                                {
                                var status = <?php echo $this->session->userdata('level')?>;
                                if(status == 7)
                                {
                                $("#hasilpenunjangimpor").load("<?php echo base_url() ?>index.php/hasil/hasilpenunjang/impor");
                                $('#hasilpenunjangimpor').dialog('open');
				}
                                else
                                {
                                alert("Tidak Bisa Impor Karena Anda Administrator");
                                }
				return false;
                                }
				});
                                

                                
                               
			});
		</script>
<form>
    <table border="0">
        <tr>
            <td width="300">Tampilkan Berdasarkan :
                <select id="hasilpenunjangjenis" onchange="sethasilpenunjangjns_tanggal();">
                <option>Pilih Jenis</option>
                <option selected value="t">Transaksi</option>
                <option value="k">Kunjungan</option>
                </select>
            </td>
            <td width="300">
                Pilih Bulan :
                <select id="hasilpenunjangbulan" onchange="sethasilpenunjangbulan();">
                    <option value="" selected>Pilih Bulan</option>
                    <option value="1">Januari</option>
                    <option value="2">Februari</option>
                    <option value="3">Maret</option>
                    <option value="4">April</option>
                    <option value="5">Mei</option>
                    <option value="6">Juni</option>
                    <option value="7">Juli</option>
                    <option value="8">Agustus</option>
                    <option value="9">September</option>
                    <option value="10">Oktober</option>
                    <option value="11">November</option>
                    <option value="12">Desember</option>
                </select>
            </td>
            <td width="200">
                Tahun :
                <select id="hasilpenunjangtahun" onchange="sethasilpenunjangtahun();">
                    <option value=''> - </option>
                    <?php
                    $tahun=date('Y');
                    for($i=2011;$i<=$tahun;$i++)
                    {?>
		     <option value="<?php echo $i;?>">
                     <?php	echo $i; ?></option>

		    <?php
		     }
                    ?>
                </select>
            </td>
            <td width="250">
                atau dari Tanggal :
                <input type="text" id="hasilpenunjangtanggal1" name="hasilpenunjangtanggal1"/>
            </td>
            <td>
                s/d
                <input type="text" id="hasilpenunjangtanggal2" name="hasilpenunjangtanggal2" onchange="sethasilpenunjangtanggal();"/>
            </td>

        </tr>
    </table>
</form>
<div id="master_hasilpenunjang" style="width: auto; height: auto;overflow: auto">
		<table id="listhasilpenunjang" class="scroll" cellpadding="0" cellspacing="0"></table>
		<div id="pagerhasilpenunjang" class="scroll" style="text-align:center;"></div>
                <div id="hasilpenunjangimpor"></div>
                <div id="detailhasilpenunjang"></div>
</div>