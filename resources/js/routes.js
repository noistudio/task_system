import StatusesIndex from './components/StatusesIndex';
import StatusesEdit from "./components/StatusesEdit";
import StatusesAdd from "./components/StatusesAdd";
import UsersIndex from "./components/UsersIndex";
import UsersAdd from "./components/UsersAdd";
import UsersEdit from "./components/UsersEdit";
import TasksIndex from "./components/TasksIndex";
import TasksAdd from "./components/TasksAdd";
import TasksEdit from "./components/TasksEdit";

export const routes = [
    {
        name: 'StatusesAll',
        path: '/statuses/all',
        component: StatusesIndex
    }, {
        path: '/statuses/:id/edit',
        name: 'status.edit',
        component: StatusesEdit,
    },
    {
        path: '/statuses/new',
        name: 'status.new',
        component: StatusesAdd,
    },
    {
        path: '/',
        name: 'users.index',
        component: UsersIndex,
    },
    {
        path: '/adduser',
        name: 'users.add',
        component: UsersAdd,
    }, {
        path: '/users/:id/edit',
        name: 'user.edit',
        component: UsersEdit,
    },
    {
        path: '/tasks',
        name: 'tasks.index',
        component: TasksIndex,
    },
    {
        path: '/tasks/add',
        name: 'tasks.add',
        component: TasksAdd,
    }, {
        path: '/tasks/:id/edit',
        name: 'tasks.edit',
        component: TasksEdit,
    }

];
