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

/* ===== NGÂN HÀNG CÂU HỎI TRUYỀN THỐNG TIỂU ĐOÀN 15 & SƯ ĐOÀN 324 ===== */
const QUESTIONS_BANK = {
  founding: [
    {
      q: 'Sư đoàn 324 (Đoàn Ngự Bình) chính thức được thành lập vào ngày tháng năm nào?',
      a: ['01/05/1954', '01/07/1955', '19/05/1959', '22/12/1944'],
      c: 1
    },
    {
      q: 'Tiểu đoàn 15 trong biên chế Sư đoàn 324 đảm nhận vai trò hỏa lực của binh chủng nào?',
      a: ['Công binh', 'Thông tin', 'Pháo binh', 'Tăng thiết giáp'],
      c: 2
    },
    {
      q: 'Sư đoàn 324 được thành lập tại địa danh nào của tỉnh Thanh Hóa?',
      a: ['Huyện Tĩnh Gia', 'Huyện Quảng Xương', 'Huyện Thọ Xuân', 'Huyện Nông Cống'],
      c: 0
    },
    {
      q: 'Khẩu hiệu truyền thống của Binh chủng Pháo binh Việt Nam là gì?',
      a: ['Quyết chiến, quyết thắng', 'Đã ra quân là đánh thắng', 'Chân đồng vai sắt, đánh giỏi bắn trúng', 'Thần tốc, táo bạo, bất ngờ'],
      c: 2
    },
    {
      q: 'Biệt danh "Đoàn Ngự Bình" của Sư đoàn 324 gắn liền với địa danh nổi tiếng nào ở miền Trung?',
      a: ['Núi Hồng Lĩnh (Hà Tĩnh)', 'Núi Ngự Bình (Thừa Thiên Huế)', 'Đèo Ngang (Quảng Bình)', 'Núi Quyết (Nghệ An)'],
      c: 1
    },
    {
      q: 'Trong kháng chiến chống Mỹ, địa bàn tác chiến trọng điểm của Sư đoàn 324 và các đơn vị trực thuộc là ở đâu?',
      a: ['Chiến trường Tây Nguyên', 'Đồng bằng Bắc Bộ', 'Chiến trường Trị - Thiên', 'Miền Đông Nam Bộ'],
      c: 2
    },
    {
      q: 'Nhiệm vụ quốc tế cao cả mà Tiểu đoàn 15 cùng Sư đoàn 324 từng thực hiện là giúp đỡ nhân dân nước nào?',
      a: ['Campuchia', 'Thái Lan', 'Lào', 'Trung Quốc'],
      c: 2
    },
    {
      q: 'Đơn vị nào sau đây là cấp trên trực tiếp của Sư đoàn 324?',
      a: ['Quân khu 1', 'Quân khu 2', 'Quân khu 4', 'Quân đoàn 1'],
      c: 2
    },
    {
      q: 'Trong chiến dịch Đường 9 - Nam Lào (1971), hỏa lực pháo binh của Sư đoàn đã góp phần tiêu diệt loại hình tác chiến nào của địch?',
      a: ['Thiết xa vận', 'Trực thăng vận', 'Chiến tranh đặc biệt', 'Cả A và B'],
      c: 3
    },
    {
      q: 'Năm 1976, Sư đoàn 324 vinh dự được Đảng và Nhà nước phong tặng danh hiệu cao quý nào?',
      a: ['Huân chương Lao động', 'Anh hùng Lực lượng vũ trang nhân dân', 'Đơn vị quyết thắng', 'Lá cờ đầu ngành hỏa lực'],
      c: 1
    },
    {
      q: 'Tiểu đoàn 15 thường thực hiện huấn luyện nội dung nào với hệ thống súng SPG-9?',
      a: ['Bắn mục tiêu cố định và di động', 'Bắn rơi máy bay tầm thấp', 'Bắn phá mìn mặt đất', 'Bắn mục tiêu trên không'],
      c: 0
    },
    {
      q: 'Trong cuộc Tổng tiến công và nổi dậy Xuân 1975, Sư đoàn 324 đã tham gia giải phóng thành phố nào đầu tiên?',
      a: ['Đà Nẵng', 'Huế', 'Sài Gòn', 'Tam Kỳ'],
      c: 1
    },
    {
      q: 'Yêu cầu quan trọng nhất đối với chiến sĩ Pháo binh Tiểu đoàn 15 trong tác chiến là gì?',
      a: ['Bắn nhanh, bắn mạnh', 'Bắn trúng ngay từ loạt đạn đầu', 'Bí mật vận chuyển pháo', 'Cả 3 phương án trên'],
      c: 3
    },
    {
      q: 'Vị trí đóng quân hiện nay của Sư đoàn 324 nằm tại tỉnh nào?',
      a: ['Thanh Hóa', 'Nghệ An', 'Hà Tĩnh', 'Quảng Trị'],
      c: 1
    },
    {
      q: 'Loại hình kỹ thuật chuyên ngành nào chiến sĩ Tiểu đoàn 15 phải thành thạo?',
      a: ['Tính toán phần tử bắn', 'Sử dụng máy thông tin vô tuyến', 'Kỹ thuật dò gỡ bom mìn', 'Kỹ thuật lái xe tăng'],
      c: 0
    },
    {
      q: 'Sư đoàn 324 tham gia chiến dịch 81 ngày đêm bảo vệ địa danh lịch sử nào năm 1972?',
      a: ['Căn cứ Dốc Miếu', 'Thành cổ Quảng Trị', 'Sân bay Tà Cơn', 'Cầu Hiền Lương'],
      c: 1
    },
    {
      q: 'Ngày truyền thống của Binh chủng Pháo binh là ngày nào?',
      a: ['29/06/1946', '22/12/1944', '19/05/1959', '15/10/1945'],
      c: 0
    },
    {
      q: 'Tiểu đoàn 15 luôn duy trì nghiêm chế độ nào để sẵn sàng xử lý các tình huống?',
      a: ['Chế độ trực sẵn sàng chiến đấu (SSCĐ)', 'Chế độ tăng gia sản xuất', 'Chế độ học tập chính trị', 'Chế độ nghỉ phép'],
      c: 0
    },
    {
      q: 'Khẩu hiệu thi đua của Sư đoàn 324 trong giai đoạn mới thường nhấn mạnh yếu tố nào?',
      a: ['Chính quy, tinh nhuệ, hiện đại', 'Vượt nắng thắng mưa, say sưa luyện tập', 'Đoàn kết, kỷ luật, vững mạnh', 'Cả 3 phương án trên'],
      c: 3
    },
    {
      q: 'Hành động "Khiêng pháo lên đỉnh dốc" trong lịch sử pháo binh thể hiện phẩm chất gì của người chiến sĩ?',
      a: ['Sức khỏe phi thường', 'Sự sáng tạo trong tác chiến', 'Ý chí quyết tâm vượt mọi gian khổ', 'Tinh thần lạc quan cách mạng'],
      c: 2
    }
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
         Tiểu đoàn 15 – SPG - 9
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
