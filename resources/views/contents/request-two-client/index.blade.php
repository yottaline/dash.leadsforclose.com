@extends('index')
@section('title', 'Request Two')
@section('search')
    <form id="nvSearch" role="search">
        <input type="search" name="q" class="form-control my-3 my-md-0 rounded-pill" placeholder="Search...">
    </form>
@endsection
@section('content')
    <div class="container-fluid" ng-app="ngApp" ng-controller="ngCtrl">
        <div class="row">
            <div class="col-12 col-sm-4 col-lg-3">
                <div class="card card-box">
                    <div class="card-body">
                        <div class="d-flex">
                            <h5 class="card-title fw-semibold pt-1 me-auto mb-3 text-uppercase">
                                <span class="text-warning" role="status"></span><span>FILTERS</span>
                            </h5>
                            <div>
                                <button type="button" class="btn btn-outline-dark btn-circle bi bi-funnel"></button>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="statusFilter">Clint Code</label>
                            <input type="text" id="code-filter" class="form-control">
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-8 col-lg-9">
                <div class="card card-box">
                    <div class="card-body">
                        <div class="d-flex">
                            <h5 class="card-title fw-semibold pt-1 me-auto mb-3 text-uppercase">REQUEST TWO CLINET</h5>
                            <div>
                                <button type="button" class="btn btn-outline-dark btn-circle bi bi-arrow-repeat"
                                    ng-click="load(true)"></button>
                            </div>
                        </div>

                        <div ng-if="list.length" class="table-responsive">
                            <table class="table table-hover" id="example">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th class="text-center">First Name</th>
                                        <th class="text-center">List Name</th>
                                        <th class="text-center">Email</th>
                                        <th class="text-center">Phone</th>
                                        <th class="text-center">UM-Steats</th>
                                        <th class="text-center">State</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr ng-repeat="cleint in list track by $index">
                                        <td ng-bind="cleint.rt_code"
                                            class="small font-monospace text-uppercase text-center">
                                        </td>
                                        <td ng-bind="cleint.rt_firstName" class="text-center">
                                        </td>
                                        <td ng-bind="cleint.rt_lastName" class="text-center">
                                        </td>
                                        <td ng-bind="cleint.rt_email" class="text-center">
                                        </td>
                                        <td ng-bind="cleint.rt_phone" class="text-center">
                                        </td>
                                        <td ng-bind="cleint.rt_umber_seats" class="text-center">
                                        </td>
                                        <td ng-bind="cleint.rt_state" class="text-center">
                                        </td>
                                        <td class="col-fit">
                                            <button class="btn btn-outline-primary btn-circle bi bi-folder-minus"
                                                ng-click="showAttachment(cleint)"></button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        @include('layouts.loader')

                    </div>
                </div>

                <div class="modal fade" id="attachment" tabindex="-1" role="dialog">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-body">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr ng-repeat="a in attachments track by $index">
                                            <td ng-bind="a.attach_file">
                                            </td>
                                            <td class="col-fit">
                                                <a href="{{ asset('attachments/<%a.attach_file%>') }}"
                                                    class="btn btn-outline-success btn-circle bi bi-cloud-arrow-down-fill"></a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        var scope,
            app = angular.module('ngApp', [], function($interpolateProvider) {
                $interpolateProvider.startSymbol('<%');
                $interpolateProvider.endSymbol('%>');
            });

        app.controller('ngCtrl', function($scope) {

            $scope.submitting = false;
            $scope.noMore = false;
            $scope.loading = false;
            $scope.q = '';
            $scope.updateCleint = false;
            $scope.attachments = false;
            $scope.list = [];
            $scope.last_id = 0;

            $scope.jsonParse = (str) => JSON.parse(str);
            $scope.load = function(reload = false) {
                if (reload) {
                    $scope.list = [];
                    $scope.last_id = 0;
                    $scope.noMore = false;
                }

                if ($scope.noMore) return;
                $scope.loading = true;
                var request = {
                    q: $scope.q,
                    last_id: $scope.last_id,
                    limit: limit,
                    code: $('#code-filter').val(),
                    _token: '{{ csrf_token() }}'
                };

                $.post("/rt_clients/load", request, function(data) {
                    var ln = data.length;
                    $scope.$apply(() => {
                        $scope.loading = false;
                        if (ln) {
                            $scope.noMore = ln < limit;
                            $scope.list = data;
                            console.log(data)
                            $scope.last_id = data[ln - 1].rt_id;
                        }
                    });
                }, 'json');
            }

            $scope.showAttachment = (cleint) => {
                var request = {
                    id: cleint.rt_id,
                    _token: '{{ csrf_token() }}'
                };
                $.post("/rt_clients/get_attachments", request, function(data) {

                    $scope.$apply(function() {
                        $scope.attachments = data;
                        setTimeout($('#attachment').modal('show'), 10000)

                    });
                }, 'json');
                // ;
            };

            $scope.load();
            scope = $scope;
        });

        $('#nvSearch').on('submit', function(e) {
            e.preventDefault();
            scope.$apply(() => scope.q = $(this).find('input').val());
            scope.load(true);
        });
    </script>
@endsection
