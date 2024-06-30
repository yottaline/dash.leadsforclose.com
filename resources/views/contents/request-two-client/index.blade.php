@extends('index')
@section('title', 'Locations')
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
                                        <th class="text-center">Status</th>
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
                                        <td ng-bind="cleint.rt_umberSeats" class="text-center">
                                        </td>
                                        <td ng-bind="cleint.rt_state" class="text-center">
                                        </td>
                                        <td class="text-center">
                                            <span ng-click="editStatus(cleint)" style="cursor:pointer"
                                                class="badge bg-<%statusObject.color[cleint.rt_status]%> rounded-pill font-monospace p-2"><%statusObject.name[cleint.rt_status]%></span>

                                        </td>
                                        <td class="col-fit">

                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        @include('layouts.loader')

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
            $scope.statusObject = {
                name: ['Un visible', 'Visible'],
                color: ['danger', 'success']
            };

            $scope.submitting = false;
            $scope.noMore = false;
            $scope.loading = false;
            $scope.q = '';
            $scope.updateCleint = false;
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

            $scope.editStatus = (cleint) => {
                var request = {
                    id: cleint.ro_id,
                    status: cleint.rt_status,
                    _token: '{{ csrf_token() }}'
                };

                $.post("/ro_clients/change_status", request, function(data) {
                    if (data.status) {
                        toastr.success('Status updated successfully');
                        $scope.$apply(function() {
                            if (scope.updateCleint === false) {
                                scope.list = data
                                    .data;
                                scope.load(true);
                            } else {
                                scope.list[scope
                                    .updateCleint] = data.data;
                            }
                        });
                    } else toastr.error("Error");
                }, 'json');
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
