<!-- Jay Windy Panggabean -->

<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/jquery-ui/jquery-ui.js"></script>
<link rel="stylesheet" type="text/css" href="js/jquery-ui/jquery-ui.css">

<?php foreach($getData as $get){?>
<div class="col-sm-6"><center>
    <div class="form-group">
        <label class="col-lg-2 control-label"></label>
        <div class="col-sm-6">
            <input type="hidden" name="txtHeaderid" id="headerid" class="form-control" value="<?php echo $get->CalonPelamarID?>">
        </div>
    </div>
    <div class="form-group">
        <label class="col-lg-2 control-label">Nama Lengkap</label> 
            <div class="col-sm-6">
                <input type="text" class="form-control" name="txtnama" id="Nama" required="" readonly="" placeholder="Input Nama" value="<?php echo $get->Nama?>">
            </div>
          <!--   <a href="#myModal" data-toggle="modal" id="btnFind" class="btn btn-success btn-sm" style="background-color: #8B008B !important; border-color: #8B008B;">
                <i class="fa fa-search"></i>
            Search Name
            </a> -->
    </div>
    <div class="form-group">
        <label class="col-lg-2 control-label">Tanggal Lahir</label>
            <div class="col-sm-6">
                <input type="text" name="txttgllahir" id="tgl_lahir" class="form-control" required="" readonly="" value="<?php echo date('d-M-Y',strtotime($get->TanggalLahir))?>">
            </div>
    </div>
    <div class="form-group">
        <label class="col-lg-2 control-label">Jenis Kelamin</label>
        <div class="col-sm-6">
            <input type="text" name="txtjeniskelamin" id="jeniskelamin" class="form-control" required="" readonly="" value="<?php echo $get->JenisKelamin?>">
        </div>
    </div></center>
</div>
<div class="col-sm-6"><center>
    <div class="form-group">
        <label class="col-lg-2 control-label"></label>
        <div class="col-sm-4">
        </div>
    </div>
    <div class="form-group">
        <label class="col-lg-2 control-label">Pendidikan Terakhir</label>
        <div class="col-sm-6">
            <input type="text" name="txtpendidikan" id="pendidikan" readonly="" class="form-control" required="" value="<?php echo $get->Pendidikan?>">
        </div>
    </div>
    <div class="form-group">
        <label class="col-lg-2 control-label">Departemen Tujuan</label>
        <div class="col-sm-6">
            <input type="text" name="txtperusahaan" id="perusahaan" required="" class= "form-control" readonly="" value="<?php echo $get->DeptAbbr?>" >
        </div>
    </div></center>
</div>
<div class="panel panel-default">
    <div class="panel-body">
        <div style="padding: 5px;">
            <table class="table table-hover table-striped table table-striped table-hover table-bordered">
                <tbody>
                    <tr>
                        <td class="col-lg-1" style="padding-top: 17px;">
                            <label for="mbti">Pilih hasil MBTI Test</label> &nbsp; &nbsp;
                            <select name="txtmbti" id="mbti">
                                <option value="ISTJ">ISTJ</option>
                                <option value="ISFJ">ISFJ</option>
                                <option value="INFJ">INFJ</option>
                                <option value="INTJ">INTJ</option>
                                <option value="ISTP">ISTP</option>
                                <option value="ISFP">ISFP</option>
                                <option value="INFP">INFP</option>
                                <option value="INTP">INTP</option>
                                <option value="ESTP">ESTP</option>
                                <option value="ESFP">ESFP</option>
                                <option value="ENFP">ENFP</option>
                                <option value="ENTP">ENTP</option>
                                <option value="ESTJ">ESTJ</option>
                                <option value="ESFJ">ESFJ</option>
                                <option value="ENFJ">ENFJ</option>
                                <option value="ENTJ">ENTJ</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4" rowspan="4"><textarea class="form-control" name="txtMbtiarea" id="Mbtiarea" placeholder="Text Area MBTI Test" required="" readonly="" rows="9" cols="50"></textarea></td>
                    </tr>
                </tbody> 
            </table>
            <div class="form-group">
                <label class="col-lg-1 control-label"></label>
                <div class="col-sm-12">
                   <button class="col-lg-12 btn btn-sm btn-primary" name="simpanMBTI" id="simpanMbti" style="background-color: #8B008B !important; border-color: #8B008B;">
                        <span class="fa fa-save"></span>
                        Simpan
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<?php }?>

<script type="text/javascript">
    $('#mbti').on('change',function(){
        var gabung = document.getElementById('mbti').value;
        // alert (gabung);
        if (gabung=="ISTJ"){
            var hasil = "*Tenang, serius, teliti dan handal dalam bekerja, praktis, orientasi pada fakta, realistis, pekerja keras dan bertanggung jawab.\n\
*Memutuskan apa yang harus dilakukan dengan logis, dan bekerja dengan tekun pada satu hal  tanpa mempedulikan gangguan, serta fokus pada target yang ingin dicapai.\n\
*Merasa senang dengan segala sesuatu yang tertib dan teratur pada pekerjaan dan kehidupan.";
        }else if (gabung=="ISFJ"){
            var hasil = "*Tenang, teliti, ramah dan dapat diandalkan.\n\
*Setia, penuh pengertian dan selalu memperhatikan hal- hal khusus dari orang orang yang mempunyai arti baginya.\n\
*Selalu mencoba untuk menciptakan lingkungan yang teratur dan harmonis di tempat kerja dan rumah.\n\
*Menyukai hal-hal praktis dan serba pasti.\n\
*Sadar akan posisi dan peran/fungsinya.";
        }else if (gabung=="INFJ"){
            var hasil = "*Selalu mencoba untuk memahami makna dan hubungan yang ada di dalam suatu ide, persahabatan serta kejadian dan hal-hal lain.\n\
*Berusaha untuk memahami orang lain dengan baik, dan mengusahakan untuk memberikan motivasi positif baginya.\n\
*Setia, teguh dan komit pada nilai-nilai yang dianutnya.\n\
*Selalu mempunyai pandangan dan sikap yang jelas tentang upaya terbaik untuk melaksanakan hal-hal demi kebaikan bersama.\n\
*Tegas, sistematis dan teratur baik melaksanakan upaya tersebut.\n\
*Selalu ingin melakukan sesuatu dengan benar.\n\
*Cenderung bekerja sendiri daripada mengambil peran sebagai pimpinan.";
        }else if (gabung=="INTJ"){
            var hasil = "*Sering mempunyai pandangan yang orisinil serta semangat yang tinggi untuk melaksanakan ide dan tujuan yang ingin dicapainya.\n\
*Mampu dengan cepat melihat suatu pola dalam suatu peristiwa-peristiwa yang terjadi dan mampu menjelaskan perspektif jangka panjangnya.\n\
*Bila sudah komit dalam suatu tugas, ia akan melaksanakan sampai tuntas dan selesai.\n\
*Agak skeptis, tidak mudah percaya dan mandiri.\n\
*Mempunyai tuntutan standar kompetensi dan hasil kinerja yang tinggi baik untuk dirinya sendiri maupun orang lain.\n\
*Secara spontan tampil sebagai pimpinan, tetapi akan patuh pada pimpinan yang dihormatinya.";
        }else if (gabung=="ISTP"){
            var hasil = "*Pendiam, tertarik pada “bagaimana” dan “ mengapa” sesuatu bisa terjadi, bersifat mekanis-praktis.\n\
*Penuh toleransi dan fleksibel, mengamati segala sesuatu masalah, bertindak cepat untuk mengatasinya dari banyak informasi yang ada, melakukan analisa untuk memisahkan apa yang berguna untuk memecahkan masalah dan mencari solusi praktis.\n\
*Senang melakukan analisa atas dasar “sebab-akibat”, mengorganisir fakta-fakta secara logis, dan menghargai efisiensi.\n\
*Menyukai olahraga yang mengandung bahaya.\n\
*Kurang peduli pada aturan dalam menyelesaikan sesuatu.";
        }else if (gabung=="ISFP"){
            var hasil = "*Sensitif, pendiam, serius dan baik hati.\n\
*Senang menikmati apa yang terjadi saat ini.\n\
*Menginginkan kebebasan untuk mengerjakan sesuatu dengan cara dan waktu sendiri.\n\
*Open minded dan fleksibel.\n\
*Tidak tertarik untuk menjadi pimpinan.\n\
*Menyukai keindahan, kreatif.\n\
*Setia dan komit untuk melakukan sesuatu untuk orang yang berarti baginya, kurang menyukai konflik dan perbedaan pendapat, karena jarang memaksakan pendapat ataupun nilai-nilai yang diyakininya pada orang lain.";
        }else if (gabung=="INFP"){
            var hasil = "*Idealis, setia terhadap nilai nilai yang dianutnya, serta setia kepada orang-orang yang dianggapnya penting.\n\
*Mempunyai rasa ingin tau yang tinggi, dan cepat melihat kesempatan yang ada.\n\
*Dapat menjadi katalisator yang baik dalam mengimplementasikan suatu ide, cepat melihat banyak kemungkinan.\n\
*Berusaha untuk memahami orang dengan baik dan membantunya untuk mengembangkan kemampuan orang tersebut secara maksimal.\n\
*Fleksibel, mudah menyesuaikan diri dan mudah mengalah, kecuali hal tersebut bertentangan dengan nilai-nilai yang dianutnya.";
        }else if (gabung=="INTP"){
            var hasil = "*Selalu mencari penjelasan logis dari hal-hal yang menarik perhatiannya.\n\
*Tertarik akan hal-hal yang teoritis dan abstrak.\n\
*Membincarakan konsep dan teori lebih menarik baginya daripada bersosialisasi.\n\
*Tenang, agak menarik diri akan tetapi cukup fleksibel dan dapat menyelesaikan diri dengan baik.\n\
*Mempunyai kemampuan untuk memusatkan perhatian untuk menangani hal-hal yang disukainya.\n\
*Tidak mudah percaya, skeptis, kadang-kadang kritis, dan selalu bersifat analitis dalam menghadapi sesuatu.";
        }else if (gabung=="ESTP"){
            var hasil = "*Fleksibel dan penuh toleransi, merasa selalu bersifat pragmatis dan berorientasi pada hasil.\n\
*Teori-teori dan konsep membosankan mereka, karena mereka ingin segera bertindak langsung menangani masalah yang dihadapi.\n\
*Perhatiannya pada saat ini, dan spontan sehingga mereka menikmati setiap kesempatan untuk beraksi dan berinteraksi dengan yang lain.\n\
*Menyukai kenikmatan hidup, kebersamaan dan gaya.\n\
*Cara belajar yang terbaik bagi mereka adalah dengan mencoba (learning by doing).\n\
*Pandai bergaul dan bersosialisasi";
        }else if (gabung=="ESFP"){
            var hasil = "*Bersahabat, ramah dan terbuka.\n\
*Sangat menyenangi kehidupan, pergaulan sosial, kebendaan dan kenikmatan hidup.\n\
*Senang bekerja sama untuk melakukan sesuatu.\n\
*Membuat pekerjaan menjadi sesuatu yang menggembirakan melalui pendekatan yang realistis dan masuk akal.\n\
*Fleksibel dan spontan, serta mudah beradaptasi dengan kenalan dan lingkungan baru.\n\
*Memiliki common sense yang baik.\n\
*Cara belajar terbaik bagi mereka adalah dengan mencoba sesuatu yang baru bersama-sama dengan orang lain.";
        }else if (gabung=="ENFP"){
            var hasil = "*Antusias, hangat, idealis dan penuh imajinasi.\n\
*Melihat kehidupan penuh dengan kesempatan.\n\
*Mampu melihat hubungan antara suatu informasi dengan suatu kejadian dan mengambil kesimpulan atas suatu kejadian tersebut, serta memerlukan penegasan dari orang lain dan sebaliknya mudah sekali memuji serta membantu orang lain.\n\
*Spontan, fleksibel dan sering mengandalkan kemampuan berimprovisasi serta kecakapan berbicara.\n\
*Serba bisa, open minded, fleksibel dengan kemampuan dan minat yang luas.";
        }else if (gabung=="ENTP"){
            var hasil = "*Kreatif, cepat, waspada, terus terang dan selalu gelisah.\n\
*Banyak akal dalam menyelesaikan masalah.\n\
*Mahir dalam mencari konsep baru dan kemudian menganalisanya secara strategis cocok atau tidak.\n\
*Mampu memahami orang lain dengan baik.\n\
*Kurang menyukai hal-hal yang rutin, dan jarang sekali mengerjakan sesuatu yang sama dengan cara yang sama.\n\
*Mampu dengan mudah mengalihkan perhatiannya dari satu hal ke hal lain.\n\
*Suka berdebat, jujur, terbuka dan asertif";
        }else if (gabung=="ESTJ"){
            var hasil = "*Praktis, realistis dan berdasarkan fakta dan apa adanya.\n\
*Tegas dapat dengan cepat membuat keputusan dan segera mengimplementasikannya.\n\
*Mampu untuk mengatur proyek dan orang untuk melaksanakan sesuatu.\n\
*Memfokuskan pada cara untuk berhasil secara efektif dan efisien.\n\
*Memperhatikan hal-hal rutin secara terperinci.\n\
*Mempunyai standar yang jelas, logis dan sistematis dan secara konsisten mematuhinya dan mengharapkan orang lain begitu pula.\n\
*Sangat tegas dalam melaksanakan rencana, menghargai kehidupan yang aman dan tenang.";
        }else if (gabung=="ESFJ"){
            var hasil = "*Hangat, populer, mudah bekerja sama akan tetapi berhati-hati.\n\
*Menginginkan kerukunan dalam harmonis di sekitar lingkungan dan pekerjaan.\n\
*Menyukai bekerja sama dengan orang lain dan menyelesaikan dengan tepat waktu dan akurat.\n\
*Setia dan memperhatikan hal-hal yang kecil.\n\
*Memperhatikan kebutuhan orang lain dan mencoba membantu untuk memenuhinya.\n\
*Ingin dihargai sebagaimana adanya dari sesuatu dan dari apa yang telah dikontribusikannya";
        }else if (gabung=="ENFJ"){
            var hasil = "*Bertanggung jawab, hangat, penuh perhatian dan responsif.\n\
*Sangat mahir untuk menyesuaikan diri dengan emosi, kebutuhan dan motivasi dari orang lain.\n\
*Mampu mengenali potensi orang lain dan siap untuk membantunya untuk mengembangkan potensi tersebut.\n\
*Sangat cocok untuk bertindak sebagai katalisator dalam pengembangan kelompok maupun dengan hubungan antara pribadi.\n\
*Setia dan responsif terhadap pujian maupun kritik.\n\
*Mudah bergaul dan mampu untuk menjadi fasilitator bagi suatu kelompok atau menjadi pemimpin yang mampu memberikan semangat.";
        }else if (gabung=="ENTJ"){
            var hasil = "*Tegas, terus terang dan selalu siap untuk memimpin.\n\
*Cepat sekali melihat kebijakan dan prosedur yang tidak logis dan tidak efisien.\n\
*Segera mengembangkan dan menerapkan sistem yang lebih komprehensif untuk memecahkan masalah-masalah organisasi.\n\
*Senang melakukan perencanaan dan penetapan sasaran jangka panjang.\n\
*Biasanya berpengetahuan luas, senang membaca dan terus menambah pengetahuannya.\n\
*Senang membagi pengetahuan dengan orang lain.\n\
*Biasanya sangat bersemangat dalam menyampaikan ide-idenya.";
        }else{
            var hasil = "Hasil dari Kombinasi Huruf Tidak ditemukan";
        }
        document.getElementById('Mbtiarea').value = hasil;
    });

    function callAjax(){
        var Nama = $('#FindByName').val();
         //alert(Nama);

        if(Nama == ''){
            alert('Data Tidak Boleh Kosong');
        }else{
            $.ajax({
                type: "GET",
                dataType: "html",
                url: "<?php echo base_url('PsychologicalAssisment/getKaryawanMbti')?>"+"/"+Nama,
                success: function(msg){
                    if(msg == ''){
                      alert('Tidak ada data');
                    } 
                    else{
                        $("#getData").html(msg);                                                     
                    }
                }
            });
        }    
    };
</script>