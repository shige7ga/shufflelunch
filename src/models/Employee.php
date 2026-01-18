<?php

class Employee extends DbModel
{
    public function fetchEmployees()
    {
        $sql = 'SELECT emp_no, emp_name FROM employees ORDER BY emp_no ASC';
        return $this->fetchAll($sql);
    }

    public function getShuffleEmployees()
    {
        $groups = [];
        $employees = $this->fetchEmployees();
        shuffle($employees);
        if (count($employees) % 2 === 0) {
            $groups = array_chunk($employees, 2);
        } else {
            $groups = array_chunk($employees, 2);
            $groups[0] = array_merge($groups[0], array_pop($groups));
        }
        return $groups;
    }

    public function registerEmployee($empNo, $empName)
    {
        $sql = 'INSERT INTO employees (emp_no, emp_name) VALUES (:emp_no, :emp_name)';
        $params = [[':emp_no', $empNo, PDO::PARAM_INT], [':emp_name', $empName, PDO::PARAM_STR]];
        $this->execute($sql, $params);
    }

    public function updateEmployee($empNo, $empName)
    {
        $sql = 'UPDATE employees SET emp_name = :emp_name WHERE emp_no = :emp_no';
        $params = [[':emp_no', $empNo, PDO::PARAM_INT], [':emp_name', $empName, PDO::PARAM_STR]];
        $this->execute($sql, $params);
    }

    public function deleteEmployee($empNo)
    {
        $sql = 'DELETE FROM employees WHERE emp_no = :emp_no';
        $params = [[':emp_no', $empNo, PDO::PARAM_INT]];
        $this->execute($sql, $params);
    }

    public function validate($empNo, $empName, $action)
    {
        $errors = [];
        if (!$empNo) {
            $errors[] = '社員番号を入力してください';
        } elseif (!is_int($empNo) && $empNo <= 0) {
            $errors[] = '社員番号は1以上の整数値で入力してください';
        } elseif ($empNo >= 10000000) {
            $errors[] = '社員番号は9,999,999以内で設定してください';
        } else {
            $stmt = $this->pdo->query("SELECT COUNT(*) FROM employees WHERE emp_no = $empNo");
            $result = $stmt->fetchColumn();
            if ($result && $action === 'create') {
                $errors[] = '入力した社員番号はすでに登録されています';
            } elseif (!$result) {
                if ($action === 'update' || $action === 'delete') {
                    $errors[] = '入力した社員番号は登録されていません';
                }
            }
        }
        if ($action !== 'delete') {
            if (!$empName) {
            $errors[] = '社員名を入力してください';
            } elseif (strlen($empName) > 100) {
                $errors[] = '社員名は100文字以内で入力してください';
            }
        }
        return $errors;
    }
}
