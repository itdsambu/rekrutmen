// JavaScript Document
function addRow(tableID) {
    var table = document.getElementById(tableID);
    var rowCount = table.rows.length;
    var row = table.insertRow(rowCount);
    var colCount = table.rows[0].cells.length;
    for (var i = 0; i < colCount; i++) {
        var newcell = row.insertCell(i);
        newcell.innerHTML = table.rows[0].cells[i].innerHTML;
        var child = newcell.children;
        for (var i2 = 0; i2 < child.length; i2++) {
            var test = newcell.children[i2].tagName;
            switch (test) {
                case "INPUT":
                    if (newcell.children[i2].type == 'checkbox') {
                        newcell.children[i2].value = "";
                        // newcell.children[i2].value = table.rows[1].cells[1].querySelector("input").value;
                        newcell.children[i2].checked = false;
                        // console.log(colCount);
                        console.log(child);
                    } else {
                        newcell.children[i2].value = "";
                        // newcell.children[i2].value = table.rows[1].cells[1].querySelector("input").value;
                        //  console.log(colCount);
                        //  console.log(child);
                    }
                    break;
                case "SELECT":
                    newcell.children[i2].value = "";
                    //  console.log(colCount);
                    //  console.log(child);
                    break;
                case "BUTTON":
                    newcell.children[i2].value = "";
                    //  console.log(colCount);
                    //  console.log(child);
                    break;
                case "TEXTAREA":
                    newcell.children[i2].value = "";
                    //  console.log(colCount);
                    //  console.log(child);
                    break;
                case "IMG":
                    newcell.children[i2].src = window.location.origin + "/qa/assets/image.png";
                    //  console.log(colCount);
                    //  console.log(child);
                    break;
                default:
                    newcell.children[i2].text = "";
                    console.log(child);
                    break;
            }
        }
    }
}


function deleteRow(tableID) {
    try {
        var table = document.getElementById(tableID);
        var rowCount = table.rows.length;
        for (var i = 0; i < rowCount; i++) {
            var row = table.rows[i];
            var chkbox = row.cells[0].childNodes[0];
            console.log(chkbox);
            if (null != chkbox && true == chkbox.checked) {
                if (rowCount <= 1) {
                    alert("Tidak dapat menghapus semua baris.");
                    break;
                }
                table.deleteRow(i);
                rowCount--;
                i--;
            }
        }
    } catch (e) {
        alert(e);
    }
}

function InsertRow(tableID) {
    try {
        var table = document.getElementById(tableID);
        var rowCount = table.rows.length;
        for (var i = 0; i < rowCount; i++) {
            var row = table.rows[i];
            var chkbox = row.cells[0].childNodes[0];
            if (null != chkbox && true == chkbox.checked) {
                var newRow = table.insertRow(i + 1);
                var colCount = table.rows[0].cells.length;
                for (h = 0; h < colCount; h++) {
                    var newCell = newRow.insertCell(h);
                    newCell.innerHTML = table.rows[0].cells[h].innerHTML;
                    var child = newCell.children;
                    for (var i2 = 0; i2 < child.length; i2++) {
                        var test = newCell.children[i2].tagName;
                        switch (test) {
                            case "INPUT":
                                if (newCell.children[i2].type == 'checkbox') {
                                    newCell.children[i2].value = "";
                                    newCell.children[i2].checked = false;
                                } else {
                                    newCell.children[i2].value = "";
                                }
                                break;
                            case "SELECT":
                                newCell.children[i2].value = "";
                                break;
                            case "TEXTAREA":
                                newCell.children[i2].value = "";
                                //  console.log(colCount);
                                //  console.log(child);
                                break;
                            default:
                                break;
                        }
                    }
                }
            }

        }
    } catch (e) {
        alert(e);
    }
}

function deleteRow2(tableID) {
    try {
        var table = document.getElementById(tableID);
        var rowCount = table.rows.length;
        for (var i = 0; i < rowCount; i++) {
            var row = table.rows[i];
            var chkbox = row.cells[0].childNodes[0];
            if (null != chkbox && true == chkbox.checked) {
                if (rowCount <= 2) {
                    alert("Tidak dapat menghapus semua baris.");
                    break;
                }
                table.deleteRow(i);
                rowCount--;
                i--;
            }
        }
    } catch (e) {
        alert(e);
    }
}


function renderselect2() {
    $(".selectaddrow").select2({
        placeholder: "Select Machine Name",
        allowClear: true
    });

    $(".part_komponen").select2({
        placeholder: "Select Part Komponen",
        allowClear: true
    });
}

function addRowselect2(tableID) { //Only Add Row in Master FORM ITEM MESIN
    var table = document.getElementById(tableID);
    var rowCount = table.rows.length;
    var row = table.insertRow(rowCount);
    var colCount = table.rows[0].cells.length;
    for (var i = 0; i < colCount; i++) {
        var newcell = row.insertCell(i);
        newcell.innerHTML = table.rows[0].cells[i].innerHTML;
        var child = newcell.children;
        for (var i2 = 0; i2 < child.length; i2++) {
            var test = newcell.children[i2].tagName;
            console.log(test);
            switch (test) {
                case "INPUT":
                    if (newcell.children[i2].type == 'checkbox') {
                        newcell.children[i2].value = "";
                        newcell.children[i2].checked = false;
                        // console.log(colCount);
                        // console.log(child);
                    } else {
                        newcell.children[i2].value = "";
                        //  console.log(colCount);
                        //  console.log(child);
                    }
                    break;
                case "SELECT":
                    if ($(newcell.children[i2]).hasClass("multiselect")) {
                        newcell.children[i2].id = "part_komponen" + rowCount;
                        newcell.children[i2].className = "part_komponen" + rowCount;
                        newcell.children[i2].name = "part_komponen[" + rowCount + "][]";
                        newcell.children[i2].value = "";
                        $('.' + newcell.children[i2].className).removeAttr('data-live-search data-select2-id aria-hidden tabindex');
                    } else {
                        newcell.children[i2].id = "selectaddrow" + rowCount;
                        newcell.children[i2].className = "selectaddrow" + rowCount;
                        newcell.children[i2].value = "";
                        $('.' + newcell.children[i2].className).removeAttr('data-live-search data-select2-id aria-hidden tabindex');
                    }
                    break;
                case "BUTTON":
                    newcell.children[i2].value = "";
                    //  console.log(colCount);
                    //  console.log(child);
                    break;
                case "IMG":
                    newcell.children[i2].src = window.location.origin + "/qa/assets/image.png";
                    //  console.log(colCount);
                    //  console.log(child);
                    break;
                default:
                    newcell.children[i2].text = "";
                    // console.log(child);
                    break;
            }
        }
    }
    var lasttr = $('#' + tableID + ' tr:last').find("span").remove();
    renderselect2();
}