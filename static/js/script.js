'use strict';

function addFormBeforeTable(parent, data, action) {
    const newDiv = document.createElement('div'),
        table = document.querySelector('table.table');

    const dataCells = data.map((el)=>{
        return `
        <td>
            <div class="input-group form-group">
                <input class="form-control" type="text" name="new_${el}" placeholder="${el}"></div>
        </td>
        `
    });

    let inputsHtml = `<form method="post" action="?q=${action}"><table class="table table-hover"><tr>`;
    dataCells.forEach((el)=>{
        inputsHtml += el;
    });
    inputsHtml += `<td><button type="submit" class="btn btn-dark">Сохранить</button></td></tr></table></form>`;

    newDiv.innerHTML = inputsHtml;
    parent.insertBefore(newDiv, table);
}


function load() {
    const addIpButton = document.querySelector('.btn-dark'),
        table = document.querySelector('table.table');

    // Добавление полей для новых IP / Пользователя
    if(addIpButton){
        addIpButton.addEventListener('click', (e)=>{
            let action = e.target.dataset.action;

            if(action) {
                e.preventDefault();
                const parentDiv = document.querySelector('.container-fluid');

                if(action === 'add_ip') {
                    addFormBeforeTable(parentDiv, ['ip', 'port'], 'addip');
                    addIpButton.style.display = 'none';
                }
                else if(action === 'add_user') {
                    addFormBeforeTable(parentDiv, ['login', 'password', 'role'], 'adduser');
                    addIpButton.style.display = 'none';
                }
            }
        });
    }


    // Управляющие кнопки Изменить / Удалить элемент
    if(table){
        table.addEventListener('click', (e)=>{
            e.preventDefault();
            let target = e.target;

            if(target.tagName === 'IMG') {
                target = target.parentElement;
            }
            if(target.tagName === 'A') {
                const parentTd = target.parentElement,
                    parentTr = parentTd.parentElement;

                if (target.tagName === 'A' && target.dataset.action === 'edit') { // Изменить элемент
                        const firstTd = parentTr.firstElementChild,
                        secondTd = firstTd.nextElementSibling;

                    let firstTdText = firstTd.innerText,
                        secondTdText = secondTd.innerText;

                    parentTd.innerHTML = "<button class='btn btn-dark edit'>Сохранить</button>";
                    firstTd.innerHTML = `<input name="ip_change" data-id='${target.dataset.id}' type='text' value='${firstTdText}'>`;
                    secondTd.innerHTML = `<input name="port_change" data-id='${target.dataset.id}' type='text' value='${secondTdText}'>`;

                    let saveButton = parentTd.querySelector('button.edit');
                    saveButton.addEventListener('click', (e)=>{
                        e.preventDefault();
                        const data = new FormData();
                        let newIp = firstTd.querySelector('input').value,
                            newPort = secondTd.querySelector('input').value;

                        data.append('id', target.dataset.id);
                        data.append('ip_change', newIp);
                        data.append('port_change', newPort);

                        const xhr = new XMLHttpRequest();
                        xhr.open('POST', '/async_handler.php');
                        xhr.send(data);
                        xhr.onreadystatechange = function() {
                            if(xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                                console.log(xhr.responseText);
                                if(xhr.responseText === 'success') {
                                    saveButton.disabled = 'disabled';
                                    firstTd.innerHTML = newIp;
                                    secondTd.innerHTML = newPort;
                                } else {
                                    alert(xhr.responseText);
                                }
                            }
                        }
                    });
                } else if(target.tagName === 'A' && target.dataset.action === 'delete') { // Удалить элемент
                    console.log(parentTr);
                    let id = target.dataset.id;
                    const data = new FormData();
                    data.append('delete_ip', id);
                    const xhr = new XMLHttpRequest();
                    xhr.open('POST', '/async_handler.php');
                    xhr.send(data);
                    xhr.onreadystatechange = function() {
                        if(xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                            console.log(xhr.responseText);
                            if(xhr.responseText === 'success') {
                                parentTr.remove()
                            } else {
                                alert(xhr.responseText);
                            }
                        }
                    }
                } else if (target.tagName === 'A' && target.dataset.action === 'use_login') { // Войти под логином
                    let id = target.dataset.id;
                    const data = new FormData();
                    data.append('login_id', id);
                    const xhr = new XMLHttpRequest();
                    xhr.open('POST', '/async_handler.php');
                    xhr.send(data);
                    xhr.onreadystatechange = function() {
                        if(xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                            console.log(xhr.responseText);
                            if(xhr.responseText === 'success') {
                                document.location.reload();
                            } else {
                                alert(xhr.responseText);
                            }
                        }
                    }
                } else if (target.tagName === 'A' && target.dataset.action === 'delete_user') { // Удалить пользователя
                    let id = target.dataset.id;
                    const data = new FormData();
                    data.append('delete_id', id);
                    const xhr = new XMLHttpRequest();
                    xhr.open('POST', '/async_handler.php');
                    xhr.send(data);
                    xhr.onreadystatechange = function() {
                        if(xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                            console.log(xhr.responseText);
                            if(xhr.responseText === 'success') {
                                document.location.reload();
                            } else {
                                alert(xhr.responseText);
                            }
                        }
                    }
                }
            }
        });
    }


















}

document.addEventListener('DOMContentLoaded', load);
