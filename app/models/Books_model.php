<?php
class Books_model extends Model  {

    /**
     * processNumAuth - Extracts the number of author to be entered from the $_POST
     *                  superglobal and returns it.
     * @return string
     */

    public function processNumAuth() {
        return $_POST['number_of_authors'];
    }

    /**
     * getIds
     * 
     * @return string
     */
    
    public function getIds() {
        Session::set('bookSearchError', false, 'errors');
        $data = Validate::isFilled($_POST);

        $data = Utility::unsetEmptyArrayVals($data);

        $page = isset($_GET['page']) ? $_GET['page'] : 1;

        $empty = ($data == []) ? true : false;
        $res = '';

        if ($empty) {
            Session::set('bookSearchError', true, 'errors');
            $res = 'empty';
            return $res;
        }
        
    // Search by ISBN
        
        if (isset($data['ISBN'])) {
            $res = $this->db->query('SELECT book_id FROM books WHERE ISBN = ' . $data['ISBN']);
             
        } else 
        
    // Search by title or UDC
        
        if (!isset($data['authors_names']) && !isset($data['authors_surnames'])) {
            $query = 'SELECT book_id FROM books WHERE';
            $queryAddons = [];
            
            if (isset($data['title'])) {
                $queryAddons[] = ' title LIKE "%' . $data['title'] . '%"';
                unset($data['title']);
            }
            
            if (isset($data['UDC'])) {
                $queryAddons[] = ' UDC = :UDC';
            }

            if (count($queryAddons) > 1) {
                $length = count($queryAddons) - 1;
                        
                for ($i = 0; $i < $length; $i++) {
                    $queryAddons[$i] .= ' AND ';
                }
            }
            
            foreach ($queryAddons as $text) {
                $query .= $text;
            }
            $query .= ';';
            $res = $this->db->query($query, $data);
        } else 
            
    // Searching by authors only        
            
            if (!isset($data['title']) && !isset($data['UDC'])) {

            $names = '';
            $surnames = '';
            
            if (isset($data['authors_names'])) {
                $names= Validate::searchByAuthorsData($data['authors_names']);
            }
            
            if (isset($data['authors_surnames'])) {
                $surnames= Validate::searchByAuthorsData($data['authors_surnames']);
            }
    
            if ($names) {
                $names = '(' . $names . ')';
            } 
            
            if ($surnames) {
                $surnames = '(' . $surnames . ')';
            } 

            $query = 'SELECT books.book_id FROM books, authors, book_authors WHERE
                        books.book_id = book_authors.book_id AND
                        book_authors.author_id = authors.author_id AND ';
            
            if ($names && !$surnames) {
                $query .= 'authors.author_name in ' . $names . ';';
            } else if ($surnames && !$names) {
                $query .= 'authors.author_surname in ' . $surnames . ';';
            } else {
                $query .= 'authors.author_name in ' . $names . ' AND ' . 'authors.author_surname in ' . $surnames . ';';
            }
            
            $res = $this->db->query($query);
        } else {
            
        // Search by all data
            
            $query = 'SELECT books.book_id FROM books, authors, book_authors WHERE ';
            if (isset($data['title']) && !isset($data['UDC'])) {
                $query .= 'books.title LIKE  "%' . $data['title'] . '%"';
            } else if (!isset($data['UDC']) && isset($data['title'])) {
                $query .= 'books.UDC = ' . $data['UDC'];
            } else {
                $query .= 'books.title LIKE "%' . $data['title'] . '%" AND books.UDC = ' . $data['UDC'];
            }
            
            $query .= ' AND books.book_id = book_authors.book_id AND book_authors.author_id = authors.author_id AND ';
            
            $names = '';
            $surnames = '';
            
            if (isset($data['authors_names'])) {
                $names= Validate::searchByAuthorsData($data['authors_names']);
            }
            
            if (isset($data['authors_surnames'])) {
                $surnames= Validate::searchByAuthorsData($data['authors_surnames']);
            }
    
            if ($names) {
                $names = '(' . $names . ')';
            } 
            
            if ($surnames) {
                $surnames = '(' . $surnames . ')';
            } 
            
            if (isset($data['authors_names']) && !isset($data['authors_surnames'])) {
                $query .= ' authors.author_name in ' . $names;
            } else if (isset($data['authors_surnames']) && !isset($data['authors_names'])) {
                $query .= ' authors.author_surname in ' . $surnames;
            } else {
                $query .= ' authors.author_name in ' . $names . ' AND ' . ' authors.author_surname in ' . $surnames;
            }
            
            $query .= ';';
            $res = $this->db->query($query);
        }
            
        $result = [];
        foreach($res as $item) {
            array_push($result, $item->book_id);
        }
        
        return $result;
    }
    
    /**
     * bookSearch
     * 
     * @param type $booksController
     */
    
    public function bookSearch($booksController, $ids2 = []) {

        if ($ids2 == []) {
            $ids = $this->getIds();
        } else if (gettype($ids2) !== 'array') {
            $ids = [];
            $ids[] = $ids2;
        }

        if ($ids == 'empty') {
            $booksController->loadView('books/index');
            die;
        }
        
        $result = [];

        if (isset($ids)) {
            foreach ($ids as $id) {
                $query = 'SELECT * FROM books WHERE book_id = ' . $id;
                $book = $this->db->query($query)[0];
                $authors = '';

                $authors_data = 'SELECT concat(authors.author_name, " ", authors.author_surname) as author
                            FROM authors, book_authors
                            WHERE authors.author_id = book_authors.author_id
                            AND book_authors.book_id = ' . $id . ';';

               $authors_data = $this->db->query($authors_data);

               foreach ($authors_data as $author) {
                   $authors .= $author->author . '<br />';
               }

               $authors = rtrim($authors, '<br />');

               $single_book_data = [];
               $single_book_data['book_id'] = $book->book_id;
               $single_book_data['title'] = $book->title;
               $single_book_data['ISBN'] = $book->ISBN;
               $single_book_data['UDC'] = $book->UDC;
               $single_book_data['authors'] = $authors;
               $single_book_data['numberOfCopies'] = $book->number_of_copies;
               $single_book_data['availableCopies'] = $book->available_copies;

               array_push($result, $single_book_data);
            }
        }
        
        return $result;
    }
    
    /**
     * addBook - Functionality for adding a book into the database.
     * 
     *           Data from the $_POST superglobal is cleaned and split into
     *              data about books in general ($book_data), 
     *              data about particular copy of the book ($physical_book_data),
     *              data about authors of the book ($authors_data).
     * 
     *           Data is validated. If an item of data is not valid, the script stops
     *           and an error is shown to the user.
     * 
     *           It is checked if the title alredy exists in the database.
     * 
     *              If yes, physical copy of the book is added to the database and `number_of_copies` 
     *              column in `books` table is updated.
     * 
     *              If not, first there is a check if the entered authors exist in the database.
     *                  Those who do not, are added.
     *                  Entries ar made into the `books_authors` table which contains relations
     *                  books and authors.
     *                  Finally, physical copy is added and `number_of_copies` 
     *                  column in `books` table is updated. 
     */
    
    public function addBook($book_controller, $number_of_authors) {
        
    // Organizing received data.

        $data = Validate::isFilled($_POST);
        
    // Storing new book data into session
        
        Session::set('newBookData', $data);

        $arrays = Utility::splitAssocArr($data, ['title', 'inventory_number', 'UDC', 'ISBN']); 
        $book_data = $arrays[1];
        $authors_data = $arrays[0];
        $physical_book_data = [];
        $physical_book_data['inventory_number'] = $book_data['inventory_number'];
        unset($book_data['inventory_number']);    
        
    // Validating the data.

        $res = Validate::validateBook($book_data, $physical_book_data, $authors_data); 
  
        if ($res) {
            $data = [];
            $data['res'] = $res;
            $data['number_of_authors'] = $number_of_authors;      
            $book_controller->loadView('books/bookEntryError', $data);
            return;
        }
        
    // Checking whether the title already exists in the database.
        
        $book_id = null;
        $book_exists = $this->db->query('SELECT * FROM books WHERE ISBN = ' . $book_data['ISBN']);

    // If the title is already in the database, only a physical book entry is added
    // and the `number_of_copies` column in `books` is updated.

        if ($book_exists) {
            
        // Book exists in the database.
            $book_exists = $book_exists[0];
            $book_id = $book_exists->book_id;
        } else {
            
        // Book does NOT exist in the database.
            
        // Adding the book.
            
            $book_id = $this->db->insertFields('books', $book_data);
 
        // Checking whether author exists in database and inserting those who don't.
            
            $authors = array_chunk($authors_data, 2);
            $authors_ids = [];

            foreach ($authors as $author) {
                $data = [];
                $data['author_name'] = $author[0];
                $data['author_surname'] = $author[1];

                $res = $this->db->selectOne('authors', $data);

                if ($res) {
                    array_push($authors_ids, $res->author_id);
                } else {
                    $id = $this->db->insertFields('authors', $data);
                    array_push($authors_ids, $id);
                }
            }

        // Adding to the `books_authors table`
            
            foreach ($authors_ids as $id) {
                $this->db->insertFields('book_authors', ['book_id' => $book_id, 'author_id' => $id]);
            } 
        }
        
    // Adding the physical book
        
        $data = [];
        $data['inventory_number'] = $physical_book_data['inventory_number'];
        $data['title'] = $book_id;
        $data['status'] = 'available';
        
        $this->db->insert('copies', $data);
        
    // Updating the `number_of_copies` in `books` table

        $data = $this->db->query('SELECT number_of_copies, available_copies FROM books WHERE book_id = ' . $book_id);

        $data = $data[0];
        $number_of_copies = isset($data->number_of_copies) ? $data->number_of_copies : null;
        $available_copies = isset($data->available_copies) ? $data->available_copies : null;
        
        if ($number_of_copies == null) {
            $number_of_copies = 1;
            $available_copies = 1;
        } else {
            $number_of_copies++;
            $available_copies++;
        }

        $query = 'UPDATE books SET number_of_copies = ' . $number_of_copies .
                ', available_copies = ' . $available_copies . ' WHERE book_id =' . $book_id;
        $this->db->query($query);
        
        unset($_SESSION['newBookData']);
        $book_controller->loadView('books/bookAddedSuccessfully');
    }
    
    /**
     * editBookSave
     * 
     * @param type $book_ontroller
     * @param type $book_id
     */
    
    public function editBookSave($book_ontroller, $book_id) {
        $data = Validate::isFilled($_POST);
        $this->db->update('books', $data, 'book_id = ' . $book_id);
        $book_ontroller->loadView('books/index');
    }
    
    /**
     * 
     * @param type $book_id
     */
    
    public function loadAuthors($book_id) {
        $query = 'SELECT * FROM authors, book_authors
                    WHERE authors.author_id = book_authors.author_id AND
                    book_authors.book_id = :book_id;';
        
        $data = [];
        $data['book_id'] = $book_id;
        
        $res = $this->db->query($query, $data);
        $res['book_id'] = $book_id;
        return $res;
    }
    
    /**
     * 
     * @param type $book_id
     */
    
    public function saveAuthorChange($book_id, $books_controller) {
        $data = Validate::isFilled($_POST);
        $data = array_chunk($data, 2);
        
        $authors_ids = [];
        
        foreach ($data as $author) {
            if ($author[0] == '' && $author[0] == '') {
                continue;
            }
            
            $query = 'SELECT author_id FROM authors WHERE author_name = :name AND author_surname = :surname;';
            $query_data = [];
            $query_data['name'] = $author[0];
            $query_data['surname'] = $author[1];
            $res = $this->db->query($query, $query_data);
            if ($res) {
                $res = $res[0]->author_id;
                array_push($authors_ids, $res);
            } else {
                $query2 = 'INSERT INTO authors SET author_name = :name, author_surname = :surname';
                $query2_data = [];
                $query2_data['name'] = $author[0];
                $query2_data['surname'] = $author[1];
                $res2 = $this->db->query($query2, $query2_data);
                $id = $this->db->lastInsertId();
                array_push($authors_ids, $id);
            }
        }
        
        $delete_query_data = [];
        $delete_query_data['book_id'] = $book_id;
        $this->db->query('DELETE FROM book_authors WHERE book_id = :book_id;', $delete_query_data);
        
        foreach ($authors_ids as $id) {
            $insert_query = 'INSERT INTO book_authors SET author_id = :author_id, book_id = :book_id;';
            $insert_query_data = [];
            $insert_query_data['author_id'] = $id;
            $insert_query_data['book_id'] = $book_id;
            $this->db->query($insert_query, $insert_query_data);
        }
        $books_controller->loadView('books/index');
    }
    
    /**
     * 
     * @param type $books_controller
     */
    
    public function addAuthors($books_controller) {
       $data = Validate::isFilled($_POST);
       $books_controller->loadView('books/addAuthorsPage', $data);
    }
    
    /**
     * 
     * @param type $book_id
     * @param type $books_controller
     */
    
    public function addAuthorsSave($books_controller, $book_id) {
        $data = Validate::isFilled($_POST);
        $data = array_chunk($data, 2);
        
        $authors_ids = [];
        
        foreach ($data as $author) {
            if ($author[0] == '' && $author[0] == '') {
                continue;
            }
            
            $query = 'SELECT author_id FROM authors WHERE author_name = :name AND author_surname = :surname;';
            $query_data = [];
            $query_data['name'] = $author[0];
            $query_data['surname'] = $author[1];
            $res = $this->db->query($query, $query_data);
            if ($res) {
                $res = $res[0]->author_id;
                array_push($authors_ids, $res);
            } else {
                $query2 = 'INSERT INTO authors SET author_name = :name, author_surname = :surname';
                $query2_data = [];
                $query2_data['name'] = $author[0];
                $query2_data['surname'] = $author[1];
                $res2 = $this->db->query($query2, $query2_data);
                $id = $this->db->lastInsertId();
                array_push($authors_ids, $id);
            }
        }
        
        foreach ($authors_ids as $id) {
            $insert_query = 'INSERT INTO book_authors SET author_id = :author_id, book_id = :book_id;';
            $insert_query_data = [];
            $insert_query_data['author_id'] = $id;
            $insert_query_data['book_id'] = $book_id;
            $this->db->query($insert_query, $insert_query_data);
        }
        $books_controller->loadView('books/authorsAdded');
    }
    
    /**
     * 
     */
    
    public function copies($book_id) {
        $data = [];
        $data['title'] = $book_id;
        $query = 'SELECT * FROM copies WHERE title = :title';
        $res = $this->db->query($query, $data);
        
        $query2 = 'SELECT title FROM books WHERE book_id = :book_id';
        $data2 = [];
        $data2['book_id'] = $book_id;
        $name = $this->db->query($query2, $data2);
 
        $name = $name[0]->title;

        $length = count($res);
        for ($i = 0; $i < $length; $i++) {
            if ($res[$i]->status == 'leased') {
                $user = $this->db->query(
                    'SELECT users.membership_number, users.id
                    FROM users, leasing
                    WHERE users.id = leasing.member_id
                    AND leasing.date_of_return is null
                    AND leasing.copy_id = '.$res[$i]->copy_id.';');
                $length = count($user);
                $user = $user[($length - 1)];
                $res[$i]->user = $user;
            }
        }
 
        $res['book_title'] = $name;
        return $res;
    }
}