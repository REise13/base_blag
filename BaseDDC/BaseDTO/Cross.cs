using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace BaseDTO
{
    public class DTO_CrossCategory
    {
        public int Id { get; set; }
        public int IdProfile { get; set; }
        public int IdCategory { get; set; }

    }

    public class DTO_CrossNeed
    {
        public int Id { get; set; }
        public int IdProfile { get; set; }
        public int IdNeed { get; set; }

    }

    public class DTO_CrossTraining
    {
        public int Id { get; set; }
        public int IdProfile { get; set; }
        public int IdTraining { get; set; }
        public DateTime DateTraining { get; set; }

    }
}
