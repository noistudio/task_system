import StatusesIndex from './components/StatusesIndex';
import StatusesEdit from "./components/StatusesEdit";
import StatusesAdd from "./components/StatusesAdd";
import UsersIndex from "./components/UsersIndex";
import UsersAdd from "./components/UsersAdd";
import UsersEdit from "./components/UsersEdit";
import TasksIndex from "./components/TasksIndex";
import TasksAdd from "./components/TasksAdd";
import TasksEdit from "./components/TasksEdit";
import Login from "./components/Login";
import axios from "axios";


const guard = function (to, from, next, isadmin) {
    // check for valid auth token


    var token = localStorage.getItem('api_token');

    axios.defaults.headers.common['Authorization'] = `Bearer ` + token;
    axios.get('/api/user')
        .then(function (resp) {


            if (resp.data.isadmin == 1 && isadmin == true) {

                next();
            } else if (isadmin == false) {
                next();
            } else {

            }


        })
        .catch(function () {
            window.location.href = "/login";
        });

};
export const routes = [
    {
        name: 'StatusesAll',
        path: '/statuses/all',
        component: StatusesIndex,
        beforeEnter: (to, from, next) => {
            guard(to, from, next, true);
        }
    }, {
        path: '/statuses/:id/edit',
        name: 'status.edit',
        component: StatusesEdit,
        beforeEnter: (to, from, next) => {
            guard(to, from, next, true);
        }
    },
    {
        path: '/statuses/new',
        name: 'status.new',
        component: StatusesAdd,
        beforeEnter: (to, from, next) => {
            guard(to, from, next, true);
        }
    },
    {
        path: '/',
        name: 'users.index',
        component: UsersIndex,
        beforeEnter: (to, from, next) => {
            guard(to, from, next, true);
        }
    },
    {
        path: '/adduser',
        name: 'users.add',
        component: UsersAdd,
        beforeEnter: (to, from, next) => {
            guard(to, from, next, true);
        }
    }, {
        path: '/users/:id/edit',
        name: 'user.edit',
        component: UsersEdit,
        beforeEnter: (to, from, next) => {
            guard(to, from, next, true);
        }
    },
    {
        path: '/tasks',
        name: 'tasks.index',
        component: TasksIndex,
        beforeEnter: (to, from, next) => {
            guard(to, from, next, false);
        }
    },
    {
        path: '/tasks/add',
        name: 'tasks.add',
        component: TasksAdd,
        beforeEnter: (to, from, next) => {
            guard(to, from, next, true);
        }
    }, {
        path: '/tasks/:id/edit',
        name: 'tasks.edit',
        component: TasksEdit,
        beforeEnter: (to, from, next) => {
            guard(to, from, next, true);
        }
    }, {
        path: '/login',
        name: 'auth.login',
        component: Login,
    }


];
