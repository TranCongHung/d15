@extends('layouts.app')

@section('title', 'Trắc nghiệm Sư đoàn 324')

@section('content')
<div id="root" class="min-h-screen"></div>
@endsection

@section('scripts')
<script src="https://unpkg.com/@babel/standalone/babel.min.js"></script>

<script type="importmap">
{
  "imports": {
    "react": "https://esm.sh/react@^19.2.3",
    "react-dom/client": "https://esm.sh/react-dom@^19.2.3/client"
  }
}
</script>

<script type="text/babel" data-type="module">
import React, { useState, useEffect } from 'react';
import ReactDOM from 'react-dom/client';

/* ===== NGÂN HÀNG CÂU HỎI ===== */
const QUESTIONS_BANK = {
  founding: [
    {
      q: 'Sư đoàn 324 (Đoàn Ngự Bình) thành lập vào ngày tháng năm nào?',
      a: ['01/05/1954', '01/07/1955', '19/05/1959', '22/12/1944'],
      c: 1
    },
    {
      q: 'Mật danh của Sư đoàn 324 là gì?',
      a: ['Đoàn Khe Sanh', 'Đoàn Ngự Bình', 'Đoàn Tây Sơn', 'Đoàn Đồng Lộc'],
      c: 1
    }
    // 👉 thêm ≥ 20 câu
  ]
};

const TOTAL_TIME = 40 * 60; // 40 phút (giây)

const App = () => {
  const [view, setView] = useState('home');
  const [questions, setQuestions] = useState([]);
  const [index, setIndex] = useState(0);
  const [answers, setAnswers] = useState([]);
  const [timeLeft, setTimeLeft] = useState(TOTAL_TIME);

  /* ===== BẮT ĐẦU ===== */
  const startQuiz = () => {
    const list = [...QUESTIONS_BANK.founding]
      .sort(() => 0.5 - Math.random())
      .slice(0, 20);

    setQuestions(list);
    setAnswers([]);
    setIndex(0);
    setTimeLeft(TOTAL_TIME);
    setView('quiz');
  };

  /* ===== ĐẾM GIỜ ===== */
  useEffect(() => {
    if (view !== 'quiz') return;

    if (timeLeft <= 0) {
      setView('result');
      return;
    }

    const timer = setInterval(() => {
      setTimeLeft(t => t - 1);
    }, 1000);

    return () => clearInterval(timer);
  }, [view, timeLeft]);

  /* ===== TRẢ LỜI ===== */
  const answer = (i) => {
    const record = {
      question: questions[index],
      selected: i
    };

    setAnswers([...answers, record]);

    if (index < questions.length - 1) {
      setIndex(index + 1);
    } else {
      setView('result');
    }
  };

  const formatTime = (s) => {
    const m = Math.floor(s / 60);
    const sec = s % 60;
    return `${m}:${sec.toString().padStart(2, '0')}`;
  };

  /* ===== LÀM BÀI ===== */
  if (view === 'quiz') {
    const q = questions[index];

    return (
      <div className="min-h-screen flex items-center justify-center px-6">
        <div className="bg-white p-10 rounded-2xl shadow-xl max-w-xl w-full">
          <div className="flex justify-between text-sm text-slate-400 mb-4">
            <span>Câu {index + 1} / {questions.length}</span>
            <span>⏱ {formatTime(timeLeft)}</span>
          </div>

          <h2 className="text-xl font-bold mb-6">{q.q}</h2>

          {q.a.map((a, i) => (
            <button
              key={i}
              onClick={() => answer(i)}
              className="block w-full text-left p-4 border rounded-lg mb-3 hover:bg-red-50"
            >
              {a}
            </button>
          ))}
        </div>
      </div>
    );
  }

  /* ===== KẾT QUẢ ===== */
  if (view === 'result') {
    const correctCount = answers.filter(
      a => a.selected === a.question.c
    ).length;

    const percent = Math.round((correctCount / questions.length) * 100);

    return (
      <div className="min-h-screen px-6 py-12">
        <div className="max-w-3xl mx-auto bg-white rounded-3xl shadow-xl p-10">
          <h2 className="text-3xl font-black text-center mb-6">
            Kết quả trắc nghiệm
          </h2>

          <div className="text-center mb-10">
            <div className="text-6xl font-black text-military-red">
              {percent}%
            </div>
            <p className="text-lg mt-2">
              Đúng {correctCount} / {questions.length} câu
            </p>
          </div>

          <div className="space-y-4">
            {answers.map((a, i) => {
              const correct = a.selected === a.question.c;
              return (
                <div
                  key={i}
                  className={`p-4 rounded-xl border-l-4 ${
                    correct
                      ? 'bg-emerald-50 border-emerald-500'
                      : 'bg-red-50 border-red-500'
                  }`}
                >
                  <p className="font-bold">
                    {i + 1}. {a.question.q}
                  </p>
                  <p className="text-sm mt-1">
                    Đáp án đúng:
                    <span className="font-semibold text-emerald-700 ml-1">
                      {a.question.a[a.question.c]}
                    </span>
                  </p>
                  {!correct && (
                    <p className="text-sm text-red-600">
                      Bạn chọn: {a.question.a[a.selected]}
                    </p>
                  )}
                </div>
              );
            })}
          </div>

          <div className="text-center mt-10">
            <button
              onClick={() => setView('home')}
              className="bg-military-red hover:bg-red-800 text-white px-10 py-3 rounded-xl font-bold"
            >
              Làm lại
            </button>
          </div>
        </div>
      </div>
    );
  }

  /* ===== TRANG CHỦ ===== */
  return (
    <div className="min-h-screen flex items-center justify-center bg-gradient-to-br from-slate-50 to-slate-100 px-6">
      <div className="bg-white max-w-xl w-full rounded-3xl shadow-2xl p-12 text-center">
        <h1 className="text-3xl md:text-4xl font-black mb-4">
          Trắc nghiệm truyền thống
        </h1>

        <h2 className="text-2xl font-bold text-military-red mb-6">
          Sư đoàn 324 – Đoàn Ngự Bình
        </h2>

        <p className="text-slate-500 mb-10">
          Thời gian làm bài: <b>40 phút</b> — Bài gồm <b>20 câu hỏi</b>.
        </p>

        <button
          onClick={startQuiz}
          className="bg-military-red hover:bg-red-800 text-white px-12 py-4 rounded-2xl text-xl font-bold shadow-lg"
        >
          Bắt đầu trắc nghiệm
        </button>
      </div>
    </div>
  );
};

ReactDOM
  .createRoot(document.getElementById('root'))
  .render(<App />);
</script>
@endsection
