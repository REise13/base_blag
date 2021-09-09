using System;
using System.Collections.Generic;
using System.Linq;
using System.Threading.Tasks;
using Microsoft.AspNetCore.Http;
using Microsoft.AspNetCore.Mvc;
using Microsoft.EntityFrameworkCore;
using BaseDDC.Model;

namespace BaseDDC.Controllers
{
    [Route("api/[controller]")]
    [ApiController]
    public class People1Controller : ControllerBase
    {
        private readonly BaseDDCContext _context;

        public People1Controller(BaseDDCContext context)
        {
            _context = context;
        }

        // GET: api/People1
        [HttpGet]
        public IEnumerable<People> GetPeople()
        {
            return _context.People;
        }

        // GET: api/People1/5
        [HttpGet("{id}")]
        public async Task<IActionResult> GetPeople([FromRoute] int id)
        {
            if (!ModelState.IsValid)
            {
                return BadRequest(ModelState);
            }

            var people = await _context.People.FindAsync(id);

            if (people == null)
            {
                return NotFound();
            }

            return Ok(people);
        }

        // PUT: api/People1/5
        [HttpPut("{id}")]
        public async Task<IActionResult> PutPeople([FromRoute] int id, [FromBody] People people)
        {
            if (!ModelState.IsValid)
            {
                return BadRequest(ModelState);
            }

            if (id != people.Id)
            {
                return BadRequest();
            }

            _context.Entry(people).State = EntityState.Modified;

            try
            {
                await _context.SaveChangesAsync();
            }
            catch (DbUpdateConcurrencyException)
            {
                if (!PeopleExists(id))
                {
                    return NotFound();
                }
                else
                {
                    throw;
                }
            }

            return NoContent();
        }

        // POST: api/People1
        [HttpPost]
        public async Task<IActionResult> PostPeople([FromBody] People people)
        {
            if (!ModelState.IsValid)
            {
                return BadRequest(ModelState);
            }

            _context.People.Add(people);
            await _context.SaveChangesAsync();

            return CreatedAtAction("GetPeople", new { id = people.Id }, people);
        }

        // DELETE: api/People1/5
        [HttpDelete("{id}")]
        public async Task<IActionResult> DeletePeople([FromRoute] int id)
        {
            if (!ModelState.IsValid)
            {
                return BadRequest(ModelState);
            }

            var people = await _context.People.FindAsync(id);
            if (people == null)
            {
                return NotFound();
            }

            _context.People.Remove(people);
            await _context.SaveChangesAsync();

            return Ok(people);
        }

        private bool PeopleExists(int id)
        {
            return _context.People.Any(e => e.Id == id);
        }
    }
}