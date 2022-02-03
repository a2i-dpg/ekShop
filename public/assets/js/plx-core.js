//custom jquery method for toggle attr
$.fn.toggleAttr = function (attr, attr1, attr2) {
    return this.each(function () {
        var self = $(this);
        if (self.attr(attr) == attr1) self.attr(attr, attr2);
        else self.attr(attr, attr1);
    });
};
(function ($) {
    // USE STRICT
    "use strict";

    PLX.data = {
        csrf: $('meta[name="csrf-token"]').attr("content"),
        appUrl: $('meta[name="app-url"]').attr("content"),
        fileBaseUrl: $('meta[name="file-base-url"]').attr("content"),
    };
    PLX.uploader = {
        data: {
            selectedFiles: [],
            selectedFilesObject: [],
            clickedForDelete: null,
            allFiles: [],
            multiple: false,
            type: "all",
            next_page_url: null,
            prev_page_url: null,
        },
        removeInputValue: function (id, array, elem) {
            var selected = array.filter(function (item) {
                return item !== id;
            });
            if (selected.length > 0) {
                $(elem)
                    .find(".file-amount")
                    .html(PLX.uploader.updateFileHtml(selected));
            } else {
                elem.find(".file-amount").html(PLX.local.choose_file);
            }
            $(elem).find(".selected-files").val(selected);
        },
        removeAttachment: function () {
            $(document).on("click",'.remove-attachment', function () {
                var value = $(this)
                    .closest(".file-preview-item")
                    .data("id");
                var selected = $(this)
                    .closest(".file-preview")
                    .prev('[data-toggle="plxuploader"]')
                    .find(".selected-files")
                    .val()
                    .split(",")
                    .map(Number);

                PLX.uploader.removeInputValue(
                    value,
                    selected,
                    $(this)
                        .closest(".file-preview")
                        .prev('[data-toggle="plxuploader"]')
                );
                $(this).closest(".file-preview-item").remove();
            });
        },
        deleteUploaderFile: function () {
            $(".plx-uploader-delete").each(function () {
                $(this).on("click", function (e) {
                    e.preventDefault();
                    var id = $(this).data("id");
                    PLX.uploader.data.clickedForDelete = id;
                    $("#plxUploaderDelete").modal("show");

                    $(".plx-uploader-confirmed-delete").on("click", function (
                        e
                    ) {
                        e.preventDefault();
                        if (e.detail === 1) {
                            var clickedForDeleteObject =
                                PLX.uploader.data.allFiles[
                                    PLX.uploader.data.allFiles.findIndex(
                                        (x) =>
                                            x.id ===
                                            PLX.uploader.data.clickedForDelete
                                    )
                                ];
                            $.ajax({
                                url:
                                    PLX.data.appUrl +
                                    "/plx-uploader/destroy/" +
                                    PLX.uploader.data.clickedForDelete,
                                type: "DELETE",
                                dataType: "JSON",
                                data: {
                                    id: PLX.uploader.data.clickedForDelete,
                                    _method: "DELETE",
                                    _token: PLX.data.csrf,
                                },
                                success: function () {
                                    PLX.uploader.data.selectedFiles = PLX.uploader.data.selectedFiles.filter(
                                        function (item) {
                                            return (
                                                item !==
                                                PLX.uploader.data
                                                    .clickedForDelete
                                            );
                                        }
                                    );
                                    PLX.uploader.data.selectedFilesObject = PLX.uploader.data.selectedFilesObject.filter(
                                        function (item) {
                                            return (
                                                item !== clickedForDeleteObject
                                            );
                                        }
                                    );
                                    PLX.uploader.updateUploaderSelected();
                                    PLX.uploader.getAllUploads(
                                        PLX.data.appUrl +
                                            "/plx-uploader/get_uploaded_files"
                                    );
                                    PLX.uploader.data.clickedForDelete = null;
                                    $("#plxUploaderDelete").modal("hide");
                                },
                            });
                        }
                    });
                });
            });
        },
        uploadSelect: function () {
            $(".plx-uploader-select").each(function () {
                var elem = $(this);
                elem.on("click", function (e) {
                    var value = $(this).data("value");
                    var valueObject =
                        PLX.uploader.data.allFiles[
                            PLX.uploader.data.allFiles.findIndex(
                                (x) => x.id === value
                            )
                        ];
                    // console.log(valueObject);

                    elem.closest(".plx-file-box-wrap").toggleAttr(
                        "data-selected",
                        "true",
                        "false"
                    );
                    if (!PLX.uploader.data.multiple) {
                        elem.closest(".plx-file-box-wrap")
                            .siblings()
                            .attr("data-selected", "false");
                    }
                    if (!PLX.uploader.data.selectedFiles.includes(value)) {
                        if (!PLX.uploader.data.multiple) {
                            PLX.uploader.data.selectedFiles = [];
                            PLX.uploader.data.selectedFilesObject = [];
                        }
                        PLX.uploader.data.selectedFiles.push(value);
                        PLX.uploader.data.selectedFilesObject.push(valueObject);
                    } else {
                        PLX.uploader.data.selectedFiles = PLX.uploader.data.selectedFiles.filter(
                            function (item) {
                                return item !== value;
                            }
                        );
                        PLX.uploader.data.selectedFilesObject = PLX.uploader.data.selectedFilesObject.filter(
                            function (item) {
                                return item !== valueObject;
                            }
                        );
                    }
                    PLX.uploader.addSelectedValue();
                    PLX.uploader.updateUploaderSelected();
                });
            });
        },
        updateFileHtml: function (array) {
            var fileText = "";
            if (array.length > 1) {
                var fileText = PLX.local.files_selected;
            } else {
                var fileText = PLX.local.file_selected;
            }
            return array.length + " " + fileText;
        },
        updateUploaderSelected: function () {
            $(".plx-uploader-selected").html(
                PLX.uploader.updateFileHtml(PLX.uploader.data.selectedFiles)
            );
        },
        clearUploaderSelected: function () {
            $(".plx-uploader-selected-clear").on("click", function () {
                PLX.uploader.data.selectedFiles = [];
                PLX.uploader.addSelectedValue();
                PLX.uploader.addHiddenValue();
                PLX.uploader.resetFilter();
                PLX.uploader.updateUploaderSelected();
                PLX.uploader.updateUploaderFiles();
            });
        },
        resetFilter: function () {
            $('[name="plx-uploader-search"]').val("");
            $('[name="plx-show-selected"]').prop("checked", false);
            $('[name="plx-uploader-sort"] option[value=newest]').prop(
                "selected",
                true
            );
        },
        getAllUploads: function (url, search_key = null, sort_key = null) {
            $(".plx-uploader-all").html(
                '<div class="align-items-center d-flex h-100 justify-content-center w-100"><div class="spinner-border" role="status"></div></div>'
            );
            var params = {};
            if (search_key != null && search_key.length > 0) {
                params["search"] = search_key;
            }
            if (sort_key != null && sort_key.length > 0) {
                params["sort"] = sort_key;
            }
            else{
                params["sort"] = 'newest';
            }
            $.get(url, params, function (data, status) {
                //console.log(data);
                if(typeof data == 'string'){
                    data = JSON.parse(data);
                }
                PLX.uploader.data.allFiles = data.data;
                PLX.uploader.allowedFileType();
                PLX.uploader.addSelectedValue();
                PLX.uploader.addHiddenValue();
                //PLX.uploader.resetFilter();
                PLX.uploader.updateUploaderFiles();
                if (data.next_page_url != null) {
                    PLX.uploader.data.next_page_url = data.next_page_url;
                    $("#uploader_next_btn").removeAttr("disabled");
                } else {
                    $("#uploader_next_btn").attr("disabled", true);
                }
                if (data.prev_page_url != null) {
                    PLX.uploader.data.prev_page_url = data.prev_page_url;
                    $("#uploader_prev_btn").removeAttr("disabled");
                } else {
                    $("#uploader_prev_btn").attr("disabled", true);
                }
            });
        },
        showSelectedFiles: function () {
            $('[name="plx-show-selected"]').on("change", function () {
                if ($(this).is(":checked")) {
                    // for (
                    //     var i = 0;
                    //     i < PLX.uploader.data.allFiles.length;
                    //     i++
                    // ) {
                    //     if (PLX.uploader.data.allFiles[i].selected) {
                    //         PLX.uploader.data.allFiles[
                    //             i
                    //         ].aria_hidden = false;
                    //     } else {
                    //         PLX.uploader.data.allFiles[
                    //             i
                    //         ].aria_hidden = true;
                    //     }
                    // }
                    PLX.uploader.data.allFiles =
                        PLX.uploader.data.selectedFilesObject;
                } else {
                    // for (
                    //     var i = 0;
                    //     i < PLX.uploader.data.allFiles.length;
                    //     i++
                    // ) {
                    //     PLX.uploader.data.allFiles[
                    //         i
                    //     ].aria_hidden = false;
                    // }
                    PLX.uploader.getAllUploads(
                        PLX.data.appUrl + "/plx-uploader/get_uploaded_files"
                    );
                }
                PLX.uploader.updateUploaderFiles();
            });
        },
        searchUploaderFiles: function () {
            $('[name="plx-uploader-search"]').on("keyup", function () {
                var value = $(this).val();
                PLX.uploader.getAllUploads(
                    PLX.data.appUrl + "/plx-uploader/get_uploaded_files",
                    value,
                    $('[name="plx-uploader-sort"]').val()
                );
                // if (PLX.uploader.data.allFiles.length > 0) {
                //     for (
                //         var i = 0;
                //         i < PLX.uploader.data.allFiles.length;
                //         i++
                //     ) {
                //         if (
                //             PLX.uploader.data.allFiles[
                //                 i
                //             ].file_original_name
                //                 .toUpperCase()
                //                 .indexOf(value) > -1
                //         ) {
                //             PLX.uploader.data.allFiles[
                //                 i
                //             ].aria_hidden = false;
                //         } else {
                //             PLX.uploader.data.allFiles[
                //                 i
                //             ].aria_hidden = true;
                //         }
                //     }
                // }
                //PLX.uploader.updateUploaderFiles();
            });
        },
        sortUploaderFiles: function () {
            $('[name="plx-uploader-sort"]').on("change", function () {
                var value = $(this).val();
                PLX.uploader.getAllUploads(
                    PLX.data.appUrl + "/plx-uploader/get_uploaded_files",
                    $('[name="plx-uploader-search"]').val(),
                    value
                );

                // if (value === "oldest") {
                //     PLX.uploader.data.allFiles = PLX.uploader.data.allFiles.sort(
                //         function(a, b) {
                //             return (
                //                 new Date(a.created_at) - new Date(b.created_at)
                //             );
                //         }
                //     );
                // } else if (value === "smallest") {
                //     PLX.uploader.data.allFiles = PLX.uploader.data.allFiles.sort(
                //         function(a, b) {
                //             return a.file_size - b.file_size;
                //         }
                //     );
                // } else if (value === "largest") {
                //     PLX.uploader.data.allFiles = PLX.uploader.data.allFiles.sort(
                //         function(a, b) {
                //             return b.file_size - a.file_size;
                //         }
                //     );
                // } else {
                //     PLX.uploader.data.allFiles = PLX.uploader.data.allFiles.sort(
                //         function(a, b) {
                //             a = new Date(a.created_at);
                //             b = new Date(b.created_at);
                //             return a > b ? -1 : a < b ? 1 : 0;
                //         }
                //     );
                // }
                //PLX.uploader.updateUploaderFiles();
            });
        },
        addSelectedValue: function () {
            for (var i = 0; i < PLX.uploader.data.allFiles.length; i++) {
                if (
                    !PLX.uploader.data.selectedFiles.includes(
                        PLX.uploader.data.allFiles[i].id
                    )
                ) {
                    PLX.uploader.data.allFiles[i].selected = false;
                } else {
                    PLX.uploader.data.allFiles[i].selected = true;
                }
            }
        },
        addHiddenValue: function () {
            for (var i = 0; i < PLX.uploader.data.allFiles.length; i++) {
                PLX.uploader.data.allFiles[i].aria_hidden = false;
            }
        },
        allowedFileType: function () {
            if (PLX.uploader.data.type !== "all") {
                PLX.uploader.data.allFiles = PLX.uploader.data.allFiles.filter(
                    function (item) {
                        return item.type === PLX.uploader.data.type;
                    }
                );
            }
        },
        updateUploaderFiles: function () {
            $(".plx-uploader-all").html(
                '<div class="align-items-center d-flex h-100 justify-content-center w-100"><div class="spinner-border" role="status"></div></div>'
            );

            var data = PLX.uploader.data.allFiles;

            setTimeout(function () {
                $(".plx-uploader-all").html(null);

                if (data.length > 0) {
                    for (var i = 0; i < data.length; i++) {
                        var thumb = "";
                        var hidden = "";
                        if (data[i].type === "image") {
                            thumb =
                                '<img src="' +
                                PLX.data.fileBaseUrl +
                                data[i].file_name +
                                '" class="img-fit">';
                        } else {
                            thumb = '<i class="la la-file-text"></i>';
                        }
                        var html =
                            '<div class="plx-file-box-wrap" aria-hidden="' +
                            data[i].aria_hidden +
                            '" data-selected="' +
                            data[i].selected +
                            '">' +
                            '<div class="plx-file-box">' +
                            // '<div class="dropdown-file">' +
                            // '<a class="dropdown-link" data-toggle="dropdown">' +
                            // '<i class="la la-ellipsis-v"></i>' +
                            // "</a>" +
                            // '<div class="dropdown-menu dropdown-menu-right">' +
                            // '<a href="' +
                            // PLX.data.fileBaseUrl +
                            // data[i].file_name +
                            // '" target="_blank" download="' +
                            // data[i].file_original_name +
                            // "." +
                            // data[i].extension +
                            // '" class="dropdown-item"><i class="la la-download mr-2"></i>Download</a>' +
                            // '<a href="#" class="dropdown-item plx-uploader-delete" data-id="' +
                            // data[i].id +
                            // '"><i class="la la-trash mr-2"></i>Delete</a>' +
                            // "</div>" +
                            // "</div>" +
                            '<div class="card card-file plx-uploader-select" title="' +
                            data[i].file_original_name +
                            "." +
                            data[i].extension +
                            '" data-value="' +
                            data[i].id +
                            '">' +
                            '<div class="card-file-thumb">' +
                            thumb +
                            "</div>" +
                            '<div class="card-body">' +
                            '<h6 class="d-flex">' +
                            '<span class="text-truncate title">' +
                            data[i].file_original_name +
                            "</span>" +
                            '<span class="ext flex-shrink-0">.' +
                            data[i].extension +
                            "</span>" +
                            "</h6>" +
                            "<p>" +
                            PLX.extra.bytesToSize(data[i].file_size) +
                            "</p>" +
                            "</div>" +
                            "</div>" +
                            "</div>" +
                            "</div>";

                        $(".plx-uploader-all").append(html);
                    }
                } else {
                    $(".plx-uploader-all").html(
                        '<div class="align-items-center d-flex h-100 justify-content-center w-100 nav-tabs"><div class="text-center"><h3>No files found</h3></div></div>'
                    );
                }
                PLX.uploader.uploadSelect();
                PLX.uploader.deleteUploaderFile();
            }, 300);
        },
        inputSelectPreviewGenerate: function (elem) {
            elem.find(".selected-files").val(PLX.uploader.data.selectedFiles);
            elem.next(".file-preview").html(null);

            if (PLX.uploader.data.selectedFiles.length > 0) {

                $.post(
                    PLX.data.appUrl + "/plx-uploader/get_file_by_ids",
                    { _token: PLX.data.csrf, ids: PLX.uploader.data.selectedFiles.toString() },
                    function (data) {

                        elem.next(".file-preview").html(null);

                        if (data.length > 0) {
                            elem.find(".file-amount").html(
                                PLX.uploader.updateFileHtml(data)
                            );
                            for (
                                var i = 0;
                                i < data.length;
                                i++
                            ) {
                                var thumb = "";
                                if (data[i].type === "image") {
                                    thumb =
                                        '<img src="' +
                                        PLX.data.fileBaseUrl +
                                        data[i].file_name +
                                        '" class="img-fit">';
                                } else {
                                    thumb = '<i class="la la-file-text"></i>';
                                }
                                var html =
                                    '<div class="d-flex justify-content-between align-items-center mt-2 file-preview-item" data-id="' +
                                    data[i].id +
                                    '" title="' +
                                    data[i].file_original_name +
                                    "." +
                                    data[i].extension +
                                    '">' +
                                    '<div class="align-items-center align-self-stretch d-flex justify-content-center thumb">' +
                                    thumb +
                                    "</div>" +
                                    '<div class="col body">' +
                                    '<h6 class="d-flex">' +
                                    '<span class="text-truncate title">' +
                                    data[i].file_original_name +
                                    "</span>" +
                                    '<span class="flex-shrink-0 ext">.' +
                                    data[i].extension +
                                    "</span>" +
                                    "</h6>" +
                                    "<p>" +
                                    PLX.extra.bytesToSize(
                                        data[i].file_size
                                    ) +
                                    "</p>" +
                                    "</div>" +
                                    '<div class="remove">' +
                                    '<button class="btn btn-sm btn-link remove-attachment" type="button">' +
                                    '<i class="la la-close"></i>' +
                                    "</button>" +
                                    "</div>" +
                                    "</div>";

                                elem.next(".file-preview").append(html);
                            }
                        } else {
                            elem.find(".file-amount").html(PLX.local.choose_file);
                        }
                });
            } else {
                elem.find(".file-amount").html(PLX.local.choose_file);
            }

            // if (PLX.uploader.data.selectedFiles.length > 0) {
            //     elem.find(".file-amount").html(
            //         PLX.uploader.updateFileHtml(PLX.uploader.data.selectedFiles)
            //     );
            //     for (
            //         var i = 0;
            //         i < PLX.uploader.data.selectedFiles.length;
            //         i++
            //     ) {
            //         var index = PLX.uploader.data.allFiles.findIndex(
            //             (x) => x.id === PLX.uploader.data.selectedFiles[i]
            //         );
            //         var thumb = "";
            //         if (PLX.uploader.data.allFiles[index].type == "image") {
            //             thumb =
            //                 '<img src="' +
            //                 PLX.data.appUrl +
            //                 "/public/" +
            //                 PLX.uploader.data.allFiles[index].file_name +
            //                 '" class="img-fit">';
            //         } else {
            //             thumb = '<i class="la la-file-text"></i>';
            //         }
            //         var html =
            //             '<div class="d-flex justify-content-between align-items-center mt-2 file-preview-item" data-id="' +
            //             PLX.uploader.data.allFiles[index].id +
            //             '" title="' +
            //             PLX.uploader.data.allFiles[index].file_original_name +
            //             "." +
            //             PLX.uploader.data.allFiles[index].extension +
            //             '">' +
            //             '<div class="align-items-center align-self-stretch d-flex justify-content-center thumb">' +
            //             thumb +
            //             "</div>" +
            //             '<div class="col body">' +
            //             '<h6 class="d-flex">' +
            //             '<span class="text-truncate title">' +
            //             PLX.uploader.data.allFiles[index].file_original_name +
            //             "</span>" +
            //             '<span class="ext">.' +
            //             PLX.uploader.data.allFiles[index].extension +
            //             "</span>" +
            //             "</h6>" +
            //             "<p>" +
            //             PLX.extra.bytesToSize(
            //                 PLX.uploader.data.allFiles[index].file_size
            //             ) +
            //             "</p>" +
            //             "</div>" +
            //             '<div class="remove">' +
            //             '<button class="btn btn-sm btn-link remove-attachment" type="button">' +
            //             '<i class="la la-close"></i>' +
            //             "</button>" +
            //             "</div>" +
            //             "</div>";

            //         elem.next(".file-preview").append(html);
            //     }
            // } else {
            //     elem.find(".file-amount").html("Choose File");
            // }
        },
        editorImageGenerate: function (elem) {
            if (PLX.uploader.data.selectedFiles.length > 0) {
                for (
                    var i = 0;
                    i < PLX.uploader.data.selectedFiles.length;
                    i++
                ) {
                    var index = PLX.uploader.data.allFiles.findIndex(
                        (x) => x.id === PLX.uploader.data.selectedFiles[i]
                    );
                    var thumb = "";
                    if (PLX.uploader.data.allFiles[index].type === "image") {
                        thumb =
                            '<img src="' +
                            PLX.data.fileBaseUrl +
                            PLX.uploader.data.allFiles[index].file_name +
                            '">';
                        elem[0].insertHTML(thumb);
                        // console.log(elem);
                    }
                }
            }
        },
        dismissUploader: function () {
            $("#plxUploaderModal").on("hidden.bs.modal", function () {
                $(".plx-uploader-backdrop").remove();
                $("#plxUploaderModal").remove();
            });
        },
        trigger: function (
            elem = null,
            from = "",
            type = "all",
            selectd = "",
            multiple = false,
            callback = null
        ) {
            // $("body").append('<div class="plx-uploader-backdrop"></div>');

            var elem = $(elem);
            var multiple = multiple;
            var type = type;
            var oldSelectedFiles = selectd;
            if (oldSelectedFiles !== "") {
                PLX.uploader.data.selectedFiles = oldSelectedFiles
                    .split(",")
                    .map(Number);
            } else {
                PLX.uploader.data.selectedFiles = [];
            }
            if ("undefined" !== typeof type && type.length > 0) {
                PLX.uploader.data.type = type;
            }

            if (multiple) {
                PLX.uploader.data.multiple = true;
            }else{
                PLX.uploader.data.multiple = false;
            }

            // setTimeout(function() {
            $.post(
                PLX.data.appUrl + "/plx-uploader",
                { _token: PLX.data.csrf },
                function (data) {
                    $("body").append(data);
                    $("#plxUploaderModal").modal("show");
                    PLX.plugins.plxUppy();
                    PLX.uploader.getAllUploads(
                        PLX.data.appUrl + "/plx-uploader/get_uploaded_files",
                        null,
                        $('[name="plx-uploader-sort"]').val()
                    );
                    PLX.uploader.updateUploaderSelected();
                    PLX.uploader.clearUploaderSelected();
                    PLX.uploader.sortUploaderFiles();
                    PLX.uploader.searchUploaderFiles();
                    PLX.uploader.showSelectedFiles();
                    PLX.uploader.dismissUploader();

                    $("#uploader_next_btn").on("click", function () {
                        if (PLX.uploader.data.next_page_url != null) {
                            $('[name="plx-show-selected"]').prop(
                                "checked",
                                false
                            );
                            PLX.uploader.getAllUploads(
                                PLX.uploader.data.next_page_url
                            );
                        }
                    });

                    $("#uploader_prev_btn").on("click", function () {
                        if (PLX.uploader.data.prev_page_url != null) {
                            $('[name="plx-show-selected"]').prop(
                                "checked",
                                false
                            );
                            PLX.uploader.getAllUploads(
                                PLX.uploader.data.prev_page_url
                            );
                        }
                    });

                    $(".plx-uploader-search i").on("click", function () {
                        $(this).parent().toggleClass("open");
                    });

                    $('[data-toggle="plxUploaderAddSelected"]').on(
                        "click",
                        function () {
                            if (from === "input") {
                                PLX.uploader.inputSelectPreviewGenerate(elem);
                            } else if (from === "direct") {
                                callback(PLX.uploader.data.selectedFiles);
                            }
                            $("#plxUploaderModal").modal("hide");
                        }
                    );
                }
            );
            // }, 50);
        },
        initForInput: function () {
            $(document).on("click",'[data-toggle="plxuploader"]', function (e) {
                if (e.detail === 1) {
                    var elem = $(this);
                    var multiple = elem.data("multiple");
                    var type = elem.data("type");
                    var oldSelectedFiles = elem.find(".selected-files").val();

                    multiple = !multiple ? "" : multiple;
                    type = !type ? "" : type;
                    oldSelectedFiles = !oldSelectedFiles
                        ? ""
                        : oldSelectedFiles;

                    PLX.uploader.trigger(
                        this,
                        "input",
                        type,
                        oldSelectedFiles,
                        multiple
                    );
                }
            });
        },
        previewGenerate: function(){
            $('[data-toggle="plxuploader"]').each(function () {
                var $this = $(this);
                var files = $this.find(".selected-files").val();
                if(files != ""){
                    $.post(
                        PLX.data.appUrl + "/plx-uploader/get_file_by_ids",
                        { _token: PLX.data.csrf, ids: files },
                        function (data) {

                            $this.next(".file-preview").html(null);

                            if (data.length > 0) {
                                $this.find(".file-amount").html(
                                    PLX.uploader.updateFileHtml(data)
                                );
                                for (
                                    var i = 0;
                                    i < data.length;
                                    i++
                                ) {
                                    var thumb = "";
                                    if (data[i].type === "image") {
                                        thumb =
                                            '<img src="' +
                                            PLX.data.fileBaseUrl +
                                            data[i].file_name +
                                            '" class="img-fit">';
                                    } else {
                                        thumb = '<i class="la la-file-text"></i>';
                                    }
                                    var html =
                                        '<div class="d-flex justify-content-between align-items-center mt-2 file-preview-item" data-id="' +
                                        data[i].id +
                                        '" title="' +
                                        data[i].file_original_name +
                                        "." +
                                        data[i].extension +
                                        '">' +
                                        '<div class="align-items-center align-self-stretch d-flex justify-content-center thumb">' +
                                        thumb +
                                        "</div>" +
                                        '<div class="col body">' +
                                        '<h6 class="d-flex">' +
                                        '<span class="text-truncate title">' +
                                        data[i].file_original_name +
                                        "</span>" +
                                        '<span class="ext flex-shrink-0">.' +
                                        data[i].extension +
                                        "</span>" +
                                        "</h6>" +
                                        "<p>" +
                                        PLX.extra.bytesToSize(
                                            data[i].file_size
                                        ) +
                                        "</p>" +
                                        "</div>" +
                                        '<div class="remove">' +
                                        '<button class="btn btn-sm btn-link remove-attachment" type="button">' +
                                        '<i class="la la-close"></i>' +
                                        "</button>" +
                                        "</div>" +
                                        "</div>";

                                    $this.next(".file-preview").append(html);
                                }
                            } else {
                                $this.find(".file-amount").html(PLX.local.choose_file);
                            }
                    });
                }
            });
        }
    };
    PLX.plugins = {
        metismenu: function () {
            $('[data-toggle="plx-side-menu"]').metisMenu();
        },
        bootstrapSelect: function (refresh = "") {
            $(".plx-selectpicker").each(function (el) {
                var $this = $(this);
                if(!$this.parent().hasClass('bootstrap-select')){
                    var selected = $this.data('selected');
                    if( typeof selected !== 'undefined' ){
                        $this.val(selected);
                    }
                    $this.selectpicker({
                        size: 5,
                        noneSelectedText: PLX.local.nothing_selected,
                        virtualScroll: false
                    });
                }
                if (refresh === "refresh") {
                    $this.selectpicker("refresh");
                }
                if (refresh === "destroy") {
                    $this.selectpicker("destroy");
                }
            });
        },
        tagify: function () {
            $(".plx-tag-input").not(".tagify").each(function () {
                var $this = $(this);

                var maxTags = $this.data("max-tags");
                var whitelist = $this.data("whitelist");
                var onchange = $this.data("on-change");

                maxTags = !maxTags ? Infinity : maxTags;
                whitelist = !whitelist ? [] : whitelist;

                $this.tagify({
                    maxTags: maxTags,
                    whitelist: whitelist,
                    dropdown: {
                        enabled: 1,
                    },
                });
                try {
                    callback = eval(onchange);
                } catch (e) {
                    var callback = '';
                }
                if (typeof callback == 'function') {
                    $this.on('removeTag',function(){
                        callback();
                    });
                    $this.on('add',function(){
                        callback();
                    });
                }
            });
        },
        textEditor: function () {
            $(".plx-text-editor").each(function (el) {
                var $this = $(this);
                var buttons = $this.data("buttons");
                var minHeight = $this.data("min-height");
                var placeholder = $this.attr("placeholder");
                var format = $this.data("format");

                buttons = !buttons
                    ? [
                          ["font", ["bold", "underline", "italic", "clear"]],
                          ["para", ["ul", "ol", "paragraph"]],
                          ["style", ["style"]],
                          ["color", ["color"]],
                          ["table", ["table"]],
                          ["insert", ["link", "picture", "video"]],
                          ["view", ["fullscreen", "undo", "redo"]],
                      ]
                    : buttons;
                placeholder = !placeholder ? "" : placeholder;
                minHeight = !minHeight ? 200 : minHeight;
                format = (typeof format == 'undefined') ? false : format;

                $this.summernote({
                    toolbar: buttons,
                    placeholder: placeholder,
                    height: minHeight,
                    callbacks: {
                        onImageUpload: function (data) {
                            data.pop();
                        },
                        onPaste: function (e) {
                            if(format){
                                var bufferText = ((e.originalEvent || e).clipboardData || window.clipboardData).getData('Text');
                                e.preventDefault();
                                document.execCommand('insertText', false, bufferText);
                            }
                        }
                    }
                });

                var nativeHtmlBuilderFunc = $this.summernote('module', 'videoDialog').createVideoNode;

                $this.summernote('module', 'videoDialog').createVideoNode =  function(url)
                {
                    var wrap = $('<div class="embed-responsive embed-responsive-16by9"></div>');
                    var html = nativeHtmlBuilderFunc(url);
                        html = $(html).addClass('embed-responsive-item');
                    return wrap.append(html)[0];
                };
            });
        },
        dateRange: function () {
            $(".plx-date-range").each(function () {
                var $this = $(this);
                var today = moment().startOf("day");
                var value = $this.val();
                var startDate = false;
                var minDate = false;
                var maxDate = false;
                var advncdRange = false;
                var ranges = {
                    Today: [moment(), moment()],
                    Yesterday: [
                        moment().subtract(1, "days"),
                        moment().subtract(1, "days"),
                    ],
                    "Last 7 Days": [moment().subtract(6, "days"), moment()],
                    "Last 30 Days": [moment().subtract(29, "days"), moment()],
                    "This Month": [
                        moment().startOf("month"),
                        moment().endOf("month"),
                    ],
                    "Last Month": [
                        moment().subtract(1, "month").startOf("month"),
                        moment().subtract(1, "month").endOf("month"),
                    ],
                };

                var single = $this.data("single");
                var monthYearDrop = $this.data("show-dropdown");
                var format = $this.data("format");
                var separator = $this.data("separator");
                var pastDisable = $this.data("past-disable");
                var futureDisable = $this.data("future-disable");
                var timePicker = $this.data("time-picker");
                var timePickerIncrement = $this.data("time-gap");
                var advncdRange = $this.data("advanced-range");

                single = !single ? false : single;
                monthYearDrop = !monthYearDrop ? false : monthYearDrop;
                format = !format ? "YYYY-MM-DD" : format;
                separator = !separator ? " / " : separator;
                minDate = !pastDisable ? minDate : today;
                maxDate = !futureDisable ? maxDate : today;
                timePicker = !timePicker ? false : timePicker;
                timePickerIncrement = !timePickerIncrement ? 1 : timePickerIncrement;
                ranges = !advncdRange ? "" : ranges;

                $this.daterangepicker({
                    singleDatePicker: single,
                    showDropdowns: monthYearDrop,
                    minDate: minDate,
                    maxDate: maxDate,
                    timePickerIncrement: timePickerIncrement,
                    autoUpdateInput: false,
                    ranges: ranges,
                    locale: {
                        format: format,
                        separator: separator,
                        applyLabel: "Select",
                        cancelLabel: "Clear",
                    },
                });
                if (single) {
                    $this.on("apply.daterangepicker", function (ev, picker) {
                        $this.val(picker.startDate.format(format));
                    });
                } else {
                    $this.on("apply.daterangepicker", function (ev, picker) {
                        $this.val(
                            picker.startDate.format(format) +
                                separator +
                                picker.endDate.format(format)
                        );
                    });
                }

                $this.on("cancel.daterangepicker", function (ev, picker) {
                    $this.val("");
                });
            });
        },
        timePicker: function () {
            $(".plx-time-picker").each(function () {
                var $this = $(this);

                var minuteStep = $this.data("minute-step");
                var defaultTime = $this.data("default");

                minuteStep = !minuteStep ? 10 : minuteStep;
                defaultTime = !defaultTime ? "00:00" : defaultTime;

                $this.timepicker({
                    template: "dropdown",
                    minuteStep: minuteStep,
                    defaultTime: defaultTime,
                    icons: {
                        up: "las la-angle-up",
                        down: "las la-angle-down",
                    },
                    showInputs: false,
                });
            });
        },
        fooTable: function () {
            $(".plx-table").each(function () {
                var $this = $(this);

                var empty = $this.data("empty");
                empty = !empty ? PLX.local.nothing_found : empty;

                $this.footable({
                    breakpoints: {
                        xs: 576,
                        sm: 768,
                        md: 992,
                        lg: 1200,
                        xl: 1400,
                    },
                    cascade: true,
                    on: {
                        "ready.ft.table": function (e, ft) {
                            PLX.extra.deleteConfirm();
                            PLX.plugins.bootstrapSelect("refresh");
                        },
                    },
                    empty: empty,
                });
            });
        },
        notify: function (type = "dark", message = "") {
            $.notify(
                {
                    // options
                    message: message,
                },
                {
                    // settings
                    showProgressbar: true,
                    delay: 2500,
                    mouse_over: "pause",
                    placement: {
                        from: "bottom",
                        align: "left",
                    },
                    animate: {
                        enter: "animated fadeInUp",
                        exit: "animated fadeOutDown",
                    },
                    type: type,
                    template:
                        '<div data-notify="container" class="plx-notify alert alert-{0}" role="alert">' +
                        '<button type="button" aria-hidden="true" data-notify="dismiss" class="close"><i class="las la-times"></i></button>' +
                        '<span data-notify="message">{2}</span>' +
                        '<div class="progress" data-notify="progressbar">' +
                        '<div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>' +
                        "</div>" +
                        "</div>",
                }
            );
        },
        plxUppy: function () {
            if ($("#plx-upload-files").length > 0) {
                var uppy = Uppy.Core({
                    autoProceed: true,
                });
                uppy.use(Uppy.Dashboard, {
                    target: "#plx-upload-files",
                    inline: true,
                    showLinkToFileUploadResult: false,
                    showProgressDetails: true,
                    hideCancelButton: true,
                    hidePauseResumeButton: true,
                    hideUploadButton: true,
                    proudlyDisplayPoweredByUppy: false,
                    locale: {
                        strings: {
                            addMoreFiles: PLX.local.add_more_files,
                            addingMoreFiles: PLX.local.adding_more_files,
                            dropPaste: PLX.local.drop_files_here_paste_or+' %{browse}',
                            browse: PLX.local.browse,
                            uploadComplete: PLX.local.upload_complete,
                            uploadPaused: PLX.local.upload_paused,
                            resumeUpload: PLX.local.resume_upload,
                            pauseUpload: PLX.local.pause_upload,
                            retryUpload: PLX.local.retry_upload,
                            cancelUpload: PLX.local.cancel_upload,
                            xFilesSelected: {
                                0: '%{smart_count} '+PLX.local.file_selected,
                                1: '%{smart_count} '+PLX.local.files_selected
                            },
                            uploadingXFiles: {
                                0: PLX.local.uploading+' %{smart_count} '+PLX.local.file,
                                1: PLX.local.uploading+' %{smart_count} '+PLX.local.files
                            },
                            processingXFiles: {
                                0: PLX.local.processing+' %{smart_count} '+PLX.local.file,
                                1: PLX.local.processing+' %{smart_count} '+PLX.local.files
                            },
                            uploading: PLX.local.uploading,
                            complete: PLX.local.complete,
                        }
                    }
                });
                uppy.use(Uppy.XHRUpload, {
                    endpoint: PLX.data.appUrl + "/plx-uploader/upload",
                    fieldName: "plx_file",
                    formData: true,
                    headers: {
                        'X-CSRF-TOKEN': PLX.data.csrf,
                    },
                });
                uppy.on("upload-success", function () {
                    PLX.uploader.getAllUploads(
                        PLX.data.appUrl + "/plx-uploader/get_uploaded_files"
                    );
                });
            }
        },
        tooltip: function () {
            $('body').tooltip({selector: '[data-toggle="tooltip"]'}).click(function () {
                $('[data-toggle="tooltip"]').tooltip("hide");
            });
        },
        countDown: function () {
            if ($(".plx-count-down").length > 0) {
                $(".plx-count-down").each(function () {

                    var $this = $(this);
                    var date = $this.data("date");
                    // console.log(date)

                    $this.countdown(date).on("update.countdown", function (event) {
                        var $this = $(this).html(
                            event.strftime(
                                "" +
                                    '<div class="countdown-item"><span class="countdown-digit">%-D</span></div><span class="countdown-separator">:</span>' +
                                    '<div class="countdown-item"><span class="countdown-digit">%H</span></div><span class="countdown-separator">:</span>' +
                                    '<div class="countdown-item"><span class="countdown-digit">%M</span></div><span class="countdown-separator">:</span>' +
                                    '<div class="countdown-item"><span class="countdown-digit">%S</span></div>'
                            )
                        );
                    });

                });
            }
        },
        slickCarousel: function () {
            $(".plx-carousel").not(".slick-initialized").each(function () {
                var $this = $(this);


                var slidesPerViewXxs = $this.data("xxs-items");
                var slidesPerViewXs = $this.data("xs-items");
                var slidesPerViewSm = $this.data("sm-items");
                var slidesPerViewMd = $this.data("md-items");
                var slidesPerViewLg = $this.data("lg-items");
                var slidesPerViewXl = $this.data("xl-items");
                var slidesPerView = $this.data("items");

                var slidesCenterMode = $this.data("center");
                var slidesArrows = $this.data("arrows");
                var slidesDots = $this.data("dots");
                var slidesRows = $this.data("rows");
                var slidesAutoplay = $this.data("autoplay");
                var slidesFade = $this.data("fade");
                var asNavFor = $this.data("nav-for");
                var infinite = $this.data("infinite");
                var focusOnSelect = $this.data("focus-select");
                var adaptiveHeight = $this.data("auto-height");


                var vertical = $this.data("vertical");
                //var verticalXxs = $this.data("vertical-xxs");
                var verticalXs = $this.data("vertical-xs");
                var verticalSm = $this.data("vertical-sm");
                var verticalMd = $this.data("vertical-md");
                var verticalLg = $this.data("vertical-lg");
                var verticalXl = $this.data("vertical-xl");

                slidesPerView = !slidesPerView ? 1 : slidesPerView;
                slidesPerViewXl = !slidesPerViewXl ? slidesPerView : slidesPerViewXl;
                slidesPerViewLg = !slidesPerViewLg ? slidesPerViewXl : slidesPerViewLg;
                slidesPerViewMd = !slidesPerViewMd ? slidesPerViewLg : slidesPerViewMd;
                slidesPerViewSm = !slidesPerViewSm ? slidesPerViewMd : slidesPerViewSm;
                slidesPerViewXs = !slidesPerViewXs ? slidesPerViewSm : slidesPerViewXs;
                slidesPerViewXxs = !slidesPerViewXxs ? slidesPerViewXs : slidesPerViewXxs;


                vertical = !vertical ? false : vertical;
                verticalXl = (typeof verticalXl == 'undefined') ? vertical : verticalXl;
                verticalLg = (typeof verticalLg == 'undefined') ? verticalXl : verticalLg;
                verticalMd = (typeof verticalMd == 'undefined') ? verticalLg : verticalMd;
                verticalSm = (typeof verticalSm == 'undefined') ? verticalMd : verticalSm;
                verticalXs = (typeof verticalXs == 'undefined') ? verticalSm : verticalXs;
                //verticalXxs = (typeof verticalXxs == 'undefined') ? verticalSm : verticalXxs;


                slidesCenterMode = !slidesCenterMode ? false : slidesCenterMode;
                slidesArrows = !slidesArrows ? false : slidesArrows;
                slidesDots = !slidesDots ? false : slidesDots;
                slidesRows = !slidesRows ? 1 : slidesRows;
                slidesAutoplay = !slidesAutoplay ? false : slidesAutoplay;
                slidesFade = !slidesFade ? false : slidesFade;
                asNavFor = !asNavFor ? null : asNavFor;
                infinite = !infinite ? false : infinite;
                focusOnSelect = !focusOnSelect ? false : focusOnSelect;
                adaptiveHeight = !adaptiveHeight ? false : adaptiveHeight;


                var slidesRtl = ($("html").attr("dir") === "rtl" && !vertical) ? true : false;
                var slidesRtlXL = ($("html").attr("dir") === "rtl" && !verticalXl) ? true : false;
                var slidesRtlLg = ($("html").attr("dir") === "rtl" && !verticalLg) ? true : false;
                var slidesRtlMd = ($("html").attr("dir") === "rtl" && !verticalMd) ? true : false;
                var slidesRtlSm = ($("html").attr("dir") === "rtl" && !verticalSm) ? true : false;
                var slidesRtlXs = ($("html").attr("dir") === "rtl" && !verticalXs) ? true : false;
                var slidesRtlXxs = ($("html").attr("dir") === "rtl" && !verticalXxs) ? true : false;

                $this.slick({
                    slidesToShow: slidesPerView,
                    autoplay: slidesAutoplay,
                    dots: slidesDots,
                    arrows: slidesArrows,
                    infinite: infinite,
                    vertical: vertical,
                    verticalSwiping: true,

                    rtl: slidesRtl,
                    rows: slidesRows,
                    centerPadding: "0px",
                    centerMode: slidesCenterMode,
                    fade: slidesFade,
                    asNavFor: asNavFor,
                    focusOnSelect: focusOnSelect,
                    adaptiveHeight: adaptiveHeight,
                    slidesToScroll: 1,
                    prevArrow:
                        '<button type="button" class="slick-prev"><i class="las la-angle-left"></i></button>',
                    nextArrow:
                        '<button type="button" class="slick-next"><i class="las la-angle-right"></i></button>',
                    responsive: [
                        {
                            breakpoint: 1500,
                            settings: {
                                slidesToShow: slidesPerViewXl,
                                vertical: verticalXl,
                                rtl: slidesRtlXL,
                            },
                        },
                        {
                            breakpoint: 1200,
                            settings: {
                                slidesToShow: slidesPerViewLg,
                                vertical: verticalLg,
                                rtl: slidesRtlLg,
                            },
                        },
                        {
                            breakpoint: 992,
                            settings: {
                                slidesToShow: slidesPerViewMd,
                                vertical: verticalMd,
                                rtl: slidesRtlMd,
                            },
                        },
                        {
                            breakpoint: 768,
                            settings: {
                                slidesToShow: slidesPerViewSm,
                                vertical: verticalSm,
                                rtl: slidesRtlSm,
                            },
                        },
                        {
                            breakpoint: 576,
                            settings: {
                                slidesToShow: slidesPerViewXs,
                                vertical: verticalXs,
                                verticalSwiping: true,
                                rtl: slidesRtlXs,
                            },
                        },
                        {
                            breakpoint: 426,
                            settings: {
                                slidesToShow: slidesPerViewXxs,
                                vertical: verticalXs,
                                verticalSwiping: true,
                                rtl: slidesRtlXxs,
                            },
                        },
                    ],
                });
            });

            // === admin panel top 12 product ===
            $(".top-12-product-plx-carousel").not(".slick-initialized").each(function () {
                var $this = $(this);

                var slidesPerViewXs = $this.data("xs-items");
                var slidesPerViewSm = $this.data("sm-items");
                var slidesPerViewMd = $this.data("md-items");
                var slidesPerViewLg = $this.data("lg-items");
                var slidesPerViewXl = $this.data("xl-items");
                var slidesPerView = $this.data("items");

                var slidesCenterMode = $this.data("center");
                var slidesArrows = $this.data("arrows");
                var slidesDots = $this.data("dots");
                var slidesRows = $this.data("rows");
                var slidesAutoplay = $this.data("autoplay");
                var slidesFade = $this.data("fade");
                var asNavFor = $this.data("nav-for");
                var infinite = $this.data("infinite");
                var focusOnSelect = $this.data("focus-select");
                var adaptiveHeight = $this.data("auto-height");

                var vertical = $this.data("vertical");
                var verticalXs = $this.data("vertical-xs");
                var verticalSm = $this.data("vertical-sm");
                var verticalMd = $this.data("vertical-md");
                var verticalLg = $this.data("vertical-lg");
                var verticalXl = $this.data("vertical-xl");

                slidesPerView = !slidesPerView ? 1 : slidesPerView;
                slidesPerViewXl = !slidesPerViewXl ? slidesPerView : slidesPerViewXl;
                slidesPerViewLg = !slidesPerViewLg ? slidesPerViewXl : slidesPerViewLg;
                slidesPerViewMd = !slidesPerViewMd ? slidesPerViewLg : slidesPerViewMd;
                slidesPerViewSm = !slidesPerViewSm ? slidesPerViewMd : slidesPerViewSm;
                slidesPerViewXs = !slidesPerViewXs ? slidesPerViewSm : slidesPerViewXs;

                vertical = !vertical ? false : vertical;
                verticalXl = (typeof verticalXl == 'undefined') ? vertical : verticalXl;
                verticalLg = (typeof verticalLg == 'undefined') ? verticalXl : verticalLg;
                verticalMd = (typeof verticalMd == 'undefined') ? verticalLg : verticalMd;
                verticalSm = (typeof verticalSm == 'undefined') ? verticalMd : verticalSm;
                verticalXs = (typeof verticalXs == 'undefined') ? verticalSm : verticalXs;

                slidesCenterMode = !slidesCenterMode ? false : slidesCenterMode;
                slidesArrows = !slidesArrows ? false : slidesArrows;
                slidesDots = !slidesDots ? false : slidesDots;
                slidesRows = !slidesRows ? 1 : slidesRows;
                slidesAutoplay = !slidesAutoplay ? false : slidesAutoplay;
                slidesFade = !slidesFade ? false : slidesFade;
                asNavFor = !asNavFor ? null : asNavFor;
                infinite = !infinite ? false : infinite;
                focusOnSelect = !focusOnSelect ? false : focusOnSelect;
                adaptiveHeight = !adaptiveHeight ? false : adaptiveHeight;

                var slidesRtl = ($("html").attr("dir") === "rtl" && !vertical) ? true : false;
                var slidesRtlXL = ($("html").attr("dir") === "rtl" && !verticalXl) ? true : false;
                var slidesRtlLg = ($("html").attr("dir") === "rtl" && !verticalLg) ? true : false;
                var slidesRtlMd = ($("html").attr("dir") === "rtl" && !verticalMd) ? true : false;
                var slidesRtlSm = ($("html").attr("dir") === "rtl" && !verticalSm) ? true : false;
                var slidesRtlXs = ($("html").attr("dir") === "rtl" && !verticalXs) ? true : false;

                $this.slick({
                    slidesToShow: slidesPerView,
                    autoplay: slidesAutoplay,
                    dots: slidesDots,
                    arrows: false,
                    infinite: infinite,
                    vertical: true,
                    verticalSwiping: true,

                    rtl: slidesRtl,
                    rows: slidesRows,
                    centerPadding: "0px",
                    centerMode: slidesCenterMode,
                    fade: slidesFade,
                    asNavFor: asNavFor,
                    focusOnSelect: focusOnSelect,
                    adaptiveHeight: adaptiveHeight,
                    slidesToScroll: 1,
                    prevArrow:
                        '<button type="button" class="slick-prev"><i class="las la-angle-left"></i></button>',
                    nextArrow:
                        '<button type="button" class="slick-next"><i class="las la-angle-right"></i></button>',
                    responsive: [
                        {
                            breakpoint: 1500,
                            settings: {
                                slidesToShow: slidesPerViewXl,
                                vertical: true,
                                verticalSwiping: true,
                                rtl: slidesRtlXL,
                            },
                        },
                        {
                            breakpoint: 1200,
                            settings: {
                                slidesToShow: slidesPerViewLg,
                                vertical: true,
                                verticalSwiping: true,
                                rtl: slidesRtlLg,
                            },
                        },
                        {
                            breakpoint: 992,
                            settings: {
                                slidesToShow: slidesPerViewMd,
                                vertical: true,
                                verticalSwiping: true,
                                rtl: slidesRtlMd,
                            },
                        },
                        {
                            breakpoint: 768,
                            settings: {
                                slidesToShow: slidesPerViewSm,
                                vertical: true,
                                verticalSwiping: true,
                                rtl: slidesRtlSm,
                            },
                        },
                        {
                            breakpoint: 576,
                            settings: {
                                slidesToShow: slidesPerViewXs,
                                vertical: true,
                                verticalSwiping: true,
                                rtl: slidesRtlXs,
                            },
                        },
                    ],
                });
            });
        },
        chart: function (selector, config) {
            if (!$(selector).length) return;

            $(selector).each(function () {
                var $this = $(this);

                var plxChart = new Chart($this, config);
            });
        },
        noUiSlider: function(){
            if ($(".plx-range-slider")[0]) {
                $(".plx-range-slider").each(function () {
                    var c = document.getElementById("input-slider-range"),
                    d = document.getElementById("input-slider-range-value-low"),
                    e = document.getElementById("input-slider-range-value-high"),
                    f = [d, e];

                    noUiSlider.create(c, {
                        start: [
                            parseInt(d.getAttribute("data-range-value-low")),
                            parseInt(e.getAttribute("data-range-value-high")),
                        ],
                        connect: !0,
                        range: {
                            min: parseInt(c.getAttribute("data-range-value-min")),
                            max: parseInt(c.getAttribute("data-range-value-max")),
                        },
                    }),

                    c.noUiSlider.on("update", function (a, b) {
                        f[b].textContent = a[b];
                    }),
                    c.noUiSlider.on("change", function (a, b) {
                        rangefilter(a);
                    });
                });
            }
        },
        zoom: function(){
            if($('.img-zoom')[0]){
                $('.img-zoom').zoom({
                    magnify:1.5
                });
                if((('ontouchstart' in window) || (navigator.maxTouchPoints > 0) || (navigator.msMaxTouchPoints > 0))){
                    $('.img-zoom').trigger('zoom.destroy');
                }
            }
        },
        jsSocials: function(){
            if($('.plx-share')[0]){
                $('.plx-share').jsSocials({
                    showLabel: false,
                    showCount: false,
                    shares: [
                        {
                            share: "email",
                            logo: "lar la-envelope"
                        },
                        {
                            share: "twitter",
                            logo: "lab la-twitter"
                        },
                        {
                            share: "facebook",
                            logo: "lab la-facebook-f"
                        },
                        {
                            share: "linkedin",
                            logo: "lab la-linkedin-in"
                        },
                        {
                            share: "whatsapp",
                            logo: "lab la-whatsapp"
                        }
                    ]
                });
            }
        }
    };
    PLX.extra = {
        refreshToken: function (){
            $.get(PLX.data.appUrl+'/refresh-csrf').done(function(data){
                PLX.data.csrf = data;
            });
            // console.log(PLX.data.csrf);
        },
        mobileNavToggle: function () {
            if(window.matchMedia('(max-width: 1200px)').matches){
                $('body').addClass('side-menu-closed')
            }
            $('[data-toggle="plx-mobile-nav"]').on("click", function () {
                if ($("body").hasClass("side-menu-open")) {
                    $("body").addClass("side-menu-closed").removeClass("side-menu-open");
                } else if($("body").hasClass("side-menu-closed")) {
                    $("body").removeClass("side-menu-closed").addClass("side-menu-open");
                }else{
                    $("body").removeClass("side-menu-open").addClass("side-menu-closed");
                }
            });
            $(".plx-sidebar-overlay").on("click", function () {
                $("body").removeClass("side-menu-open").addClass('side-menu-closed');
            });
        },
        initActiveMenu: function () {
            $('[data-toggle="plx-side-menu"] a').each(function () {
                var pageUrl = window.location.href.split(/[?#]/)[0];
                if (this.href == pageUrl || $(this).hasClass("active")) {
                    $(this).addClass("active");
                    // $(this).closest(".plx-side-nav-item").addClass("mm-active");
                    $(this)
                        .closest(".level-2")
                        .siblings("a")
                        .addClass("level-2-active");
                    $(this)
                        .closest(".level-3")
                        .siblings("a")
                        .addClass("level-3-active");
                }
            });
        },
        deleteConfirm: function () {
            $(".confirm-delete").click(function (e) {
                e.preventDefault();
                var url = $(this).data("href");
                $("#delete-modal").modal("show");
                $("#delete-link").attr("href", url);
            });

            $(".confirm-cancel").click(function (e) {
                e.preventDefault();
                var url = $(this).data("href");
                $("#cancel-modal").modal("show");
                $("#cancel-link").attr("href", url);
            });

            $(".confirm-complete").click(function (e) {
                e.preventDefault();
                var url = $(this).data("href");
                $("#complete-modal").modal("show");
                $("#comfirm-link").attr("href", url);
            });

            $(".confirm-alert").click(function (e) {
                e.preventDefault();
                var url = $(this).data("href");
                var target = $(this).data("target");
                $(target).modal("show");
                $(target).find(".comfirm-link").attr("href", url);
                $("#comfirm-link").attr("href", url);
            });
        },
        bytesToSize: function (bytes) {
            var sizes = ["Bytes", "KB", "MB", "GB", "TB"];
            if (bytes == 0) return "0 Byte";
            var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
            return Math.round(bytes / Math.pow(1024, i), 2) + " " + sizes[i];
        },
        multiModal: function () {
            $(document).on("show.bs.modal", ".modal", function (event) {
                var zIndex = 1040 + 10 * $(".modal:visible").length;
                $(this).css("z-index", zIndex);
                setTimeout(function () {
                    $(".modal-backdrop")
                        .not(".modal-stack")
                        .css("z-index", zIndex - 1)
                        .addClass("modal-stack");
                }, 0);
            });
            $(document).on('hidden.bs.modal', function () {
                if($('.modal.show').length > 0){
                    $('body').addClass('modal-open');
                }
            });
        },
        bsCustomFile: function () {
            $(".custom-file input").change(function (e) {
                var files = [];
                for (var i = 0; i < $(this)[0].files.length; i++) {
                    files.push($(this)[0].files[i].name);
                }
                if (files.length === 1) {
                    $(this).next(".custom-file-name").html(files[0]);
                } else if (files.length > 1) {
                    $(this)
                        .next(".custom-file-name")
                        .html(files.length + " " + PLX.local.files_selected);
                } else {
                    $(this).next(".custom-file-name").html(PLX.local.choose_file);
                }
            });
        },
        stopPropagation: function(){
            $(document).on('click', '.stop-propagation', function (e) {
                e.stopPropagation();
            });
        },
        outsideClickHide: function(){
            $(document).on('click', function (e) {
                $('.document-click-d-none').addClass('d-none');
            });
        },
        inputRating: function () {
            $(".rating-input").each(function () {
                $(this)
                    .find("label")
                    .on({
                        mouseover: function (event) {
                            $(this).find("i").addClass("hover");
                            $(this).prevAll().find("i").addClass("hover");
                        },
                        mouseleave: function (event) {
                            $(this).find("i").removeClass("hover");
                            $(this).prevAll().find("i").removeClass("hover");
                        },
                        click: function (event) {
                            $(this).siblings().find("i").removeClass("active");
                            $(this).find("i").addClass("active");
                            $(this).prevAll().find("i").addClass("active");
                        },
                    });
                if ($(this).find("input").is(":checked")) {
                    $(this)
                        .find("label")
                        .siblings()
                        .find("i")
                        .removeClass("active");
                    $(this)
                        .find("input:checked")
                        .closest("label")
                        .find("i")
                        .addClass("active");
                    $(this)
                        .find("input:checked")
                        .closest("label")
                        .prevAll()
                        .find("i")
                        .addClass("active");
                }
            });
        },
        scrollToBottom: function () {
            $(".scroll-to-btm").each(function (i, el) {
                el.scrollTop = el.scrollHeight;
            });
        },
        classToggle: function () {
            $(document).on('click','[data-toggle="class-toggle"]',function () {
                var $this = $(this);
                var target = $this.data("target");
                var sameTriggers = $this.data("same");
                var backdrop = $(this).data("backdrop");

                if ($(target).hasClass("active")) {
                    $(target).removeClass("active");
                    $(sameTriggers).removeClass("active");
                    $this.removeClass("active");
                    $('body').removeClass("overflow-hidden");
                } else {
                    $(target).addClass("active");
                    $this.addClass("active");
                    if(backdrop == 'static'){
                        $('body').addClass("overflow-hidden");
                    }
                }
            });
        },
        collapseSidebar: function () {
            $(document).on('click','[data-toggle="collapse-sidebar"]',function (i, el) {
                var $this = $(this);
                var target = $(this).data("target");
                var sameTriggers = $(this).data("siblings");

                // var showOverlay = $this.data('overlay');
                // var overlayMarkup = '<div class="overlay overlay-fixed dark c-pointer" data-toggle="collapse-sidebar" data-target="'+target+'"></div>';

                // showOverlay = !showOverlay ? true : showOverlay;

                // if (showOverlay && $(target).siblings('.overlay').length !== 1) {
                //     $(target).after(overlayMarkup);
                // }

                e.preventDefault();
                if ($(target).hasClass("opened")) {
                    $(target).removeClass("opened");
                    $(sameTriggers).removeClass("opened");
                    $($this).removeClass("opened");
                } else {
                    $(target).addClass("opened");
                    $($this).addClass("opened");
                }
            });
        },
        autoScroll: function () {
            if ($(".plx-auto-scroll").length > 0) {
                $(".plx-auto-scroll").each(function () {
                    var options = $(this).data("options");

                    options = !options
                        ? '{"delay" : 2000 ,"amount" : 70 }'
                        : options;

                    options = JSON.parse(options);

                    this.delay = parseInt(options["delay"]) || 2000;
                    this.amount = parseInt(options["amount"]) || 70;
                    this.autoScroll = $(this);
                    this.iScrollHeight = this.autoScroll.prop("scrollHeight");
                    this.iScrollTop = this.autoScroll.prop("scrollTop");
                    this.iHeight = this.autoScroll.height();

                    var self = this;
                    this.timerId = setInterval(function () {
                        if (
                            self.iScrollTop + self.iHeight <
                            self.iScrollHeight
                        ) {
                            self.iScrollTop = self.autoScroll.prop("scrollTop");
                            self.iScrollTop += self.amount;
                            self.autoScroll.animate(
                                { scrollTop: self.iScrollTop },
                                "slow",
                                "linear"
                            );
                        } else {
                            self.iScrollTop -= self.iScrollTop;
                            self.autoScroll.animate(
                                { scrollTop: "0px" },
                                "fast",
                                "swing"
                            );
                        }
                    }, self.delay);
                });
            }
        },
        addMore: function () {
            $('[data-toggle="add-more"]').each(function () {
                var $this = $(this);
                var content = $this.data("content");
                var target = $this.data("target");

                $this.on("click", function (e) {
                    e.preventDefault();
                    $(target).append(content);
                    PLX.plugins.bootstrapSelect();
                });
            });
        },
        removeParent: function () {
            $(document).on(
                "click",
                '[data-toggle="remove-parent"]',
                function () {
                    var $this = $(this);
                    var parent = $this.data("parent");
                    $this.closest(parent).remove();
                }
            );
        },
        selectHideShow: function() {
            $('[data-show="selectShow"]').each(function() {
                var target = $(this).data("target");
                $(this).on("change", function() {
                    var value = $(this).val();
                    // console.log(value);
                    $(target)
                        .children()
                        .not("." + value)
                        .addClass("d-none");
                    $(target)
                        .find("." + value)
                        .removeClass("d-none");
                });
            });
        },
        plusMinus: function(){
            $('.plx-plus-minus input').each(function() {
                var $this = $(this);
                var min = parseInt($(this).attr("min"));
                var max = parseInt($(this).attr("max"));
                var value = parseInt($(this).val());
                if(value <= min){
                    $this.siblings('[data-type="minus"]').attr('disabled',true)
                }
                if(value >= max){
                    $this.siblings('[data-type="plus"]').attr('disabled',true)
                }
            });
            $('.plx-plus-minus button').on('click', function(e) {
                e.preventDefault();

                var fieldName = $(this).attr("data-field");
                var type = $(this).attr("data-type");
                var input = $("input[name='" + fieldName + "']");
                var currentVal = parseInt(input.val());

                if (!isNaN(currentVal)) {
                    if (type == "minus") {
                        if (currentVal > input.attr("min")) {
                            input.val(currentVal - 1).change();
                        }
                        if (parseInt(input.val()) == input.attr("min")) {
                            $(this).attr("disabled", true);
                        }
                    } else if (type == "plus") {
                        if (currentVal < input.attr("max")) {
                            input.val(currentVal + 1).change();
                        }
                        if (parseInt(input.val()) == input.attr("max")) {
                            $(this).attr("disabled", true);
                        }
                    }
                } else {
                    input.val(0);
                }
            });
            $('.plx-plus-minus input').on('change', function () {
                var minValue = parseInt($(this).attr("min"));
                var maxValue = parseInt($(this).attr("max"));
                var valueCurrent = parseInt($(this).val());

                name = $(this).attr("name");
                if (valueCurrent >= minValue) {
                    $(this).siblings("[data-type='minus']").removeAttr("disabled");
                } else {
                    alert("Sorry, the minimum limit has been reached");
                    $(this).val(minValue);
                }
                if (valueCurrent <= maxValue) {
                    $(this).siblings("[data-type='plus']").removeAttr("disabled");
                } else {
                    alert("Sorry, the maximum limit has been reached");
                    $(this).val(maxValue);
                }
            });
        },
        hovCategoryMenu: function(){
            $("#category-menu-icon, #category-sidebar")
                .on("mouseover", function (event) {
                    $("#hover-category-menu").addClass('active').removeClass('d-none');
                })
                .on("mouseout", function (event) {
                    $("#hover-category-menu").addClass('d-none').removeClass('active');
                });
        },
        trimAppUrl: function(){
            if(PLX.data.appUrl.slice(-1) == '/'){
                PLX.data.appUrl = PLX.data.appUrl.slice(0, PLX.data.appUrl.length -1);
                // console.log(PLX.data.appUrl);
            }
        },
        setCookie: function(cname, cvalue, exdays) {
            var d = new Date();
            d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
            var expires = "expires=" + d.toUTCString();
            document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
        },
        getCookie: function(cname) {
            var name = cname + "=";
            var decodedCookie = decodeURIComponent(document.cookie);
            var ca = decodedCookie.split(';');
            for (var i = 0; i < ca.length; i++) {
                var c = ca[i];
                while (c.charAt(0) === ' ') {
                    c = c.substring(1);
                }
                if (c.indexOf(name) === 0) {
                    return c.substring(name.length, c.length);
                }
            }
            return "";
        },
        acceptCookie: function(){
            if (!PLX.extra.getCookie("acceptCookies")) {
                $(".plx-cookie-alert").addClass("show");
            }
            $(".plx-cookie-accept").on("click", function() {
                PLX.extra.setCookie("acceptCookies", true, 60);
                $(".plx-cookie-alert").removeClass("show");
            });
        },
        setSession: function(){
            $('.set-session').each(function() {
                var $this = $(this);
                var key = $this.data('key');
                var value = $this.data('value');

                const now = new Date();
                const item = {
                    value: value,
                    expiry: now.getTime() + 3600000,
                };

                $this.on('click', function(){
                    localStorage.setItem(key, JSON.stringify(item));
                });
            });
        },
        showSessionPopup: function(){
            $('.removable-session').each(function() {
                var $this = $(this);
                var key = $this.data('key');
                var value = $this.data('value');
                var item = {};
                if (localStorage.getItem(key)) {
                    item = localStorage.getItem(key);
                    item = JSON.parse(item);
                }
                const now = new Date()
                if (typeof item.expiry == 'undefined' || now.getTime() > item.expiry){
                    $this.removeClass('d-none');
                }
            });
        }
    };

    setInterval(function(){
        PLX.extra.refreshToken();
    }, 3600000);

    // init plx plugins, extra options
    PLX.extra.initActiveMenu();
    PLX.extra.mobileNavToggle();
    PLX.extra.deleteConfirm();
    PLX.extra.multiModal();
    PLX.extra.inputRating();
    PLX.extra.bsCustomFile();
    PLX.extra.stopPropagation();
    PLX.extra.outsideClickHide();
    PLX.extra.scrollToBottom();
    PLX.extra.classToggle();
    PLX.extra.collapseSidebar();
    PLX.extra.autoScroll();
    PLX.extra.addMore();
    PLX.extra.removeParent();
    PLX.extra.selectHideShow();
    PLX.extra.plusMinus();
    PLX.extra.hovCategoryMenu();
    PLX.extra.trimAppUrl();
    PLX.extra.acceptCookie();
    PLX.extra.setSession();
    PLX.extra.showSessionPopup()

    PLX.plugins.metismenu();
    PLX.plugins.bootstrapSelect();
    PLX.plugins.tagify();
    PLX.plugins.textEditor();
    PLX.plugins.tooltip();
    PLX.plugins.countDown();
    PLX.plugins.dateRange();
    PLX.plugins.timePicker();
    PLX.plugins.fooTable();
    PLX.plugins.slickCarousel();
    PLX.plugins.noUiSlider();
    PLX.plugins.zoom();
    PLX.plugins.jsSocials();

    // initialization of plx uploader
    PLX.uploader.initForInput();
    PLX.uploader.removeAttachment();
    PLX.uploader.previewGenerate();

    // $(document).ajaxComplete(function(){
    //     PLX.plugins.bootstrapSelect('refresh');
    // });

})(jQuery);
