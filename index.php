<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="codebase/skins/touch.css" type="text/css" media="screen" charset="utf-8">
        <script src="codebase/webix.js" type="text/javascript" charset="utf-8"></script>
        <meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <title> Demo </title>
    </head>
    <body>
        <script>
            webix.ready(function() {
                var films = webix.ajax().sync().post("http://io.nowdb.net/collection/select_all.json",
                        {
                            "token": "5332795a8d909e0a0cfc42c6",
                            "project": "movie",
                            "collection": "films"
                        },
                function(text, xml, xhr) {
                    return text;
                });
                var datas = films.responseText;
                webix.ui.fullScreen();
                webix.ui({
                    rows: [
                        {
                            view: "multiview",
                            cells: [
                                {
                                    id: "title",
                                    view: "list",
                                    scheme: {
                                        $sort: {
                                            by: "title",
                                            dir: "asc"
                                        }
                                    },
                                    template: "#title#",
                                    data: datas,
                                    select: true
                                },
                                {
                                    id: "synopsis",
                                    view: "list",
                                    scheme: {
                                        $sort: {
                                            by: "synopsis",
                                            dir: "asc"
                                        }
                                    },
                                    template: "#synopsis#",
                                    data: datas,
                                    select: true
                                },
                                {
                                    id: "rating",
                                    view: "list",
                                    scheme: {
                                        $sort: {
                                            by: "rating",
                                            dir: "asc"
                                        }
                                    },
                                    template: "#rating#",
                                    data: datas,
                                    select: true
                                },
                                {
                                    id: "actors",
                                    view: "form",
                                    elements: [
                                        {view: "text", name: "title", label: "Title"},
                                        {view: "text", name: "synopsis", label: "Synopsis"},
                                        {view: "text", name: "rating", label: "Rating"},
                                        {
                                            cols: [
                                                {view: "button", value: "Simpan", type: "form", click: save},
                                                {view: "button", value: "Cancel"}
                                            ]
                                        }
                                    ]
                                }
                            ]
                        },
                        {
                            view: "tabbar",
                            type: "iconTop",
                            multiview: true,
                            options: [
                                {id: "title", icon: "film", value: "Title"},
                                {id: "synopsis", icon: "user", value: "Sysnopsis"},
                                {id: "rating", icon: "tags", value: "Rating"},
                                {id: "actors", icon: "tags", value: "Actors"}
                            ]

                        }
                    ]
                });
                function save() {
                    var values = {
                        "token": "5332795a8d909e0a0cfc42c6",
                        "project": "movie",
                        "collection": "films",
                        "title": $$("actors").getValues().title,
                        "synopsis":$$("synopsis").getValues().synopsis,
                        "rating": $$("rating").getValues().rating};
                    webix.ajax().post("http://io.nowdb.net/collection/insert", values, function() {
                        webix.massage({type: "debug", text: "Films is save", expire: -1});
                    });
                }
            });
        </script>
    </body>
</html>
