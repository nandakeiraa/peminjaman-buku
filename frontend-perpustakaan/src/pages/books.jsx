import { useEffect, useState } from "react";
import api from "../services/api";

export default function Books() {
  const [books, setBooks] = useState([]);

  useEffect(() => {
    api.get("/books")
      .then(res => setBooks(res.data));
  }, []);

  return (
    <div>
      <h2>Daftar Buku</h2>
      {books.map(book => (
        <div key={book.id}>
          {book.judul} - Stok: {book.stok}
        </div>
      ))}
    </div>
  );
}
